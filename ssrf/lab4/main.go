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
			w.Header().Set("Content-Type", "text/html")
			fmt.Fprint(w, `
				<div style="font-family: 'Segoe UI', sans-serif; padding: 40px; background: #f0fdf4; border: 3px dashed #10b981; border-radius: 15px;">
					<h1 style="color: #047857;">Go Internal Admin Console</h1>
					<p>Successfully authenticated from localhost.</p>
					<div style="background: white; padding: 20px; border-radius: 10px; margin-top: 20px;">
						<h3>System Secrets:</h3>
						<p><b>MASTER_KEY:</b> <code>go_vuln_key_2025_safe</code></p>
						<p><b>INTERNAL_DNS:</b> <code>consul.internal.svc</code></p>
						<p><b>PROMETHEUS_ENDPOINT:</b> <code>http://10.0.0.5:9090</code></p>
					</div>
					<p style="margin-top: 20px; color: #6b7280;">Node ID: node-gh-8821 | Region: us-east-1</p>
				</div>
			`)
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
	// Main lab handler on port 8084
	mainMux := http.NewServeMux()
	mainMux.HandleFunc("/", handler)

	// Internal service handler on port 8080
	// This replaces the need for an external httpd
	internalMux := http.NewServeMux()
	internalMux.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		http.ServeFile(w, r, "/internal/index.html")
	})

	// Start internal service in a goroutine
	go func() {
		fmt.Println("Internal service starting on port 8080...")
		if err := http.ListenAndServe(":8080", internalMux); err != nil {
			fmt.Printf("Internal service error: %v\n", err)
		}
	}()

	// Start main lab
	fmt.Println("Server starting on port 8084...")
	if err := http.ListenAndServe(":8084", mainMux); err != nil {
		fmt.Printf("Main server error: %v\n", err)
	}
}
