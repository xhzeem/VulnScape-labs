package main

import (
	"fmt"
	"io/ioutil"
	"net"
	"net/http"
	"strings"
)

func isInternal(host string) bool {
	ips, err := net.LookupIP(host)
	if err != nil {
		return false
	}
	for _, ip := range ips {
		if ip.IsLoopback() || ip.IsPrivate() {
			return true
		}
	}
	return false
}

func handler(w http.ResponseWriter, r *http.Request) {
	urlStr := r.URL.Query().Get("url")
	if urlStr == "" {
		fmt.Fprint(w, `
			<html>
				<body style="font-family: sans-serif; padding: 50px; background: #f1f5f9;">
					<div style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
						<h1>Webhook Verifier</h1>
						<p>We verify your webhook domain is public before sending data.</p>
						<form>
							<input type="text" name="url" placeholder="http://your-webhook.com" style="width: 100%; padding: 10px;">
							<button type="submit" style="margin-top: 10px; padding: 10px; background: #6366f1; color: white; border: none; cursor: pointer;">Verify</button>
						</form>
					</div>
				</body>
			</html>
		`)
		return
	}

	host := strings.Split(strings.TrimPrefix(strings.TrimPrefix(urlStr, "http://"), "https://"), "/")[0]
	if isInternal(host) {
		http.Error(w, "Error: Internal IP detected!", http.StatusForbidden)
		return
	}

	// TOCTOU Vulnerability: The host is re-resolved here during the actual request
	resp, err := http.Get(urlStr)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer resp.Body.Close()
	body, _ := ioutil.ReadAll(resp.Body)
	fmt.Fprint(w, string(body))
}

func main() {
	http.HandleFunc("/", handler)
	fmt.Println("Server starting on port 80...")
	http.ListenAndServe(":80", nil)
}
