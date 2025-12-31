from flask import Flask, request, render_template_string
import requests

app = Flask(__name__)

BLACKLIST = ["localhost", "127.0.0.1", "::1", "0.0.0.0"]

@app.route('/')
def index():
    url = request.args.get('url')
    if not url:
        return '''
        <html>
            <head><title>Secure Image Fetcher</title></head>
            <body style="font-family: sans-serif; padding: 50px; background: #e2e8f0;">
                <div style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
                    <h1>Secure Image Fetcher</h1>
                    <p>We've blocked localhost to prevent SSRF!</p>
                    <form>
                        <input type="text" name="url" placeholder="http://example.com/img.png" style="width: 100%; padding: 10px;">
                        <button type="submit" style="margin-top: 10px; padding: 10px; background: #22c55e; color: white; border: none; cursor: pointer;">Fetch</button>
                    </form>
                    <div style="margin-top: 30px; padding: 15px; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 5px;">
                        <h3 style="margin-top: 0; color: #92400e;">Internal Targets (Hints)</h3>
                        <ul>
                            <li>Admin Interface: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8082/admin</code></li>
                            <li>Secret Service: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8080</code></li>
                            <li>Cloud Metadata: <code style="background: #fee2e2; padding: 2px 4px;">http://169.254.169.254/metadata.json</code></li>
                        </ul>
                    </div>
                    <button style="margin-top: 20px; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;" onclick="window.open(window.location.href, '_blank')">🔗 Open in New Tab</button>
                </div>
            </body>
        </html>
        '''
    
    for word in BLACKLIST:
        if word in url.lower():
            return "Error: Forbidden host detected!", 403
            
    try:
        r = requests.get(url, timeout=5)
        return r.text
    except Exception as e:
        return str(e), 500

@app.route('/admin')
def admin():
    if request.remote_addr in ["127.0.0.1", "::1"]:
        return '''
        <div style="font-family: sans-serif; padding: 30px; background: #fff5f5; border: 2px solid #feb2b2; border-radius: 10px;">
            <h1 style="color: #c53030;">Critical System Administration</h1>
            <p><strong>Status:</strong> <span style="color: #38a169;">Maintenance Required</span></p>
            <h3>Sensitive System Configs:</h3>
            <ul>
                <li><strong>Log Rotation:</strong> Enabled (Daily)</li>
                <li><strong>SSH Keys:</strong> Generated 2023-12-01</li>
                <li><strong>VPN Gateway:</strong> <code>10.50.100.1</code></li>
                <li><strong>Admin Token:</strong> <code>adm_live_5522_xyz_998</code></li>
            </ul>
            <p style="font-size: 0.8em; color: #718096;">IP Log: 127.0.0.1 accessed at 2025-12-31</p>
        </div>
        '''
    return "Access Denied: Localhost only.", 403

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8082)
