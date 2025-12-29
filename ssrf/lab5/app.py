from flask import Flask, request, render_template_string
import requests

app = Flask(__name__)

@app.route('/')
def index():
    url = request.args.get('url')
    if not url:
        return '''
        <html>
            <body style="font-family: sans-serif; padding: 50px; background: #fdf2f8;">
                <div style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
                    <h1>URL Health Checker</h1>
                    <p>Enter a URL to check if it's up. (Blind SSRF)</p>
                    <form>
                        <input type="text" name="url" placeholder="http://example.com" style="width: 100%; padding: 10px;">
                        <button type="submit" style="margin-top: 10px; padding: 10px; background: #ec4899; color: white; border: none; cursor: pointer;">Check</button>
                    </form>
                    <div style="margin-top: 30px; padding: 15px; background: #fff1f2; border: 1px solid #f43f5e; border-radius: 5px;">
                        <h3 style="margin-top: 0; color: #9f1239;">Internal Targets (Hints)</h3>
                        <ul>
                            <li>Admin Interface: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8085/admin</code></li>
                            <li>Secret Service: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8080</code></li>
                            <li>Cloud Metadata: <code style="background: #fee2e2; padding: 2px 4px;">http://169.254.169.254/metadata.json</code></li>
                        </ul>
                    </div>
                    <button style="margin-top: 20px; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;" onclick="window.open(window.location.href, '_blank')">🔗 Open in New Tab</button>
                </div>
            </body>
        </html>
        '''
    
    try:
        # Blind: We don't return the content, only status
        requests.get(url, timeout=3)
        return "URL is up and reachable!"
    except Exception:
        return "URL is down or unreachable!"

@app.route('/admin')
def admin():
    if request.remote_addr in ["127.0.0.1", "::1"]:
        return "u accessed the admin page"
    return "Access Denied: Localhost only.", 403

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8085)
