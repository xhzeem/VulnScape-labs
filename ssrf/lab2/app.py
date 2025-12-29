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

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)
