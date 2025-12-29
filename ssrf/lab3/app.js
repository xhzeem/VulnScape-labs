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
                        <div style="margin-top: 30px; padding: 15px; background: #e0f2fe; border: 1px solid #0ea5e9; border-radius: 5px;">
                            <h3 style="margin-top: 0; color: #0369a1;">Internal Targets (Hints)</h3>
                            <ul>
                                <li>Admin Interface: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8083/admin</code></li>
                                <li>Secret Service: <code style="background: #fee2e2; padding: 2px 4px;">http://127.0.0.1:8080</code></li>
                                <li>Cloud Metadata: <code style="background: #fee2e2; padding: 2px 4px;">http://169.254.169.254/metadata.json</code></li>
                            </ul>
                        </div>
                        <button style="margin-top: 20px; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;" onclick="window.open(window.location.href, '_blank')">🔗 Open in New Tab</button>
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

app.get('/admin', (req, res) => {
    const remoteIp = req.socket.remoteAddress;
    if (remoteIp === '::ffff:127.0.0.1' || remoteIp === '127.0.0.1' || remoteIp === '::1') {
        res.send('u accessed the admin page');
    } else {
        res.status(403).send('Access Denied: Localhost only.');
    }
});

app.listen(8083, () => console.log('Listening on port 8083'));
