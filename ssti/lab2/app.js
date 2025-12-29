const express = require('express');
const ejs = require('ejs');
const app = express();

app.get('/', (req, res) => {
    const { name } = req.query;
    if (!name) {
        return res.send(`
            <html>
                <body style="font-family: sans-serif; padding: 50px; background: #fef2f2;">
                    <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 600px; margin: auto;">
                        <h1>Name Card Generator</h1>
                        <form>
                            <input type="text" name="name" placeholder="Your Name" style="padding: 10px; width: 80%;">
                            <button type="submit" style="padding: 10px; background: #ef4444; color: white; border: none; cursor: pointer;">Generate</button>
                        </form>
                    </div>
                </body>
            </html>
        `);
    }

    // Vulnerable: render arbitrary string as EJS template
    const template = `<h1>Welcome, ${name}</h1>`;
    try {
        const html = ejs.render(template, { flag: "FLAG{EJS_PROTOTYPE_SSTI}" });
        res.send(html);
    } catch (err) {
        res.status(500).send(err.message);
    }
});

app.listen(8088, () => console.log('EJS Lab running on port 8088'));
