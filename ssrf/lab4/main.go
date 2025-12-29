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
	if r.URL.Path == "/admin" {
		remoteIp, _, _ := net.SplitHostPort(r.RemoteAddr)
		if remoteIp == "127.0.0.1" || remoteIp == "::1" || remoteIp == "localhost" {
			fmt.Fprint(w, "u accessed the admin page")
		} else {
			http.Error(w, "Access Denied: Localhost only.", http.StatusForbidden)
		}
		return
	}

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
						<div style="margin-top: 30px; padding: 15px; background: #ecfdf5; border: 1px solid #10b981; border-radius: 5px;">
							<h3 style="margin-top: 0; color: #065f46;">Internal Targets (Hints)</h3>
							<ul>
								<li>Admin Interface: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8084/admin</code></li>
								<li>Secret Service: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8080</code></li>
								<li>Cloud Metadata: <code style="background: #fee2e2; padding: 2px 4px;">http://169.254.169.254/metadata.json</code></li>
							</ul>
						</div>
						<button style="margin-top: 20px; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;" onclick="window.open(window.location.href, '_blank')">🔗 Open in New Tab</button>
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
	http.ListenAndServe(":8084", nil)
}
