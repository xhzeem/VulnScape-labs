const express = require('express');
const axios = require('axios');
const app = express();

app.get('/', async (req, res) => {
    const { url } = req.query;
    if (!url) {
        return res.send(`
            <html>
                <body style="font-family: sans-serif; padding: 50px; background: #fef3c7;">
                    <div style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
                        <h1>Partner API Proxy</h1>
                        <p>Only requests to <b>vulnscape.com</b> are allowed.</p>
                        <form>
                            <input type="text" name="url" placeholder="http://api.vulnscape.com/v1/data" style="width: 100%; padding: 10px;">
                            <button type="submit" style="margin-top: 10px; padding: 10px; background: #d97706; color: white; border: none; cursor: pointer;">Request</button>
                        </form>
                    </div>
                </body>
            </html>
        `);
    }

    if (!url.includes('vulnscape.com')) {
        return res.status(403).send('Error: Only vulnscape.com domains are allowed!');
    }

    try {
        const response = await axios.get(url, { timeout: 3000 });
        res.send(response.data);
    } catch (error) {
        res.status(500).send(error.message);
    }
});

app.listen(80, () => console.log('Listening on port 80'));
