from flask import Flask, request, render_template_string

app = Flask(__name__)

@app.route('/')
def index():
    name = request.args.get('name', 'Guest')
    # Vulnerable line: direct interpolation into template string
    template = f'''
    <html>
        <body style="font-family: sans-serif; padding: 50px; background: #e0f2fe;">
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 600px; margin: auto;">
                <h1>Hello, {name}!</h1>
                <p>Try to find the flag in the secret variable.</p>
                <form>
                    <input type="text" name="name" placeholder="Enter your name" style="padding: 10px; width: 80%;">
                    <button type="submit" style="padding: 10px; background: #0ea5e9; color: white; border: none; cursor: pointer;">Submit</button>
                </form>
            </div>
        </body>
    </html>
    '''
    return render_template_string(template)

if __name__ == '__main__':
    # Secret flag accessible via self.template_context or global scope in some scenarios
    secret_flag = "FLAG{JINJA2_SSTI_MASTERED}"
    app.run(host='0.0.0.0', port=8087)
