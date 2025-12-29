let currentLab = null;

function loadLab(type, level, title, framework, desc) {
    // Update sidebar active state
    document.querySelectorAll('.nav-group li').forEach(el => el.classList.remove('active'));
    event.target.classList.add('active');

    // Update UI elements
    document.getElementById('welcome-screen').style.display = 'none';
    document.getElementById('lab-display').style.display = 'block';
    document.getElementById('lab-iframe-container').style.display = 'none';

    document.getElementById('lab-breadcrumb').textContent = `${type.toUpperCase()} / Lab ${level}`;
    document.getElementById('lab-title').textContent = title;
    document.getElementById('lab-lang').textContent = framework;
    document.getElementById('lab-difficulty').textContent = getDifficulty(type, level);
    document.getElementById('lab-desc').textContent = desc;

    currentLab = { type, level };
}

function getDifficulty(type, level) {
    if (type === 'ssrf') {
        if (level === 1) return 'Easy';
        if (level < 4) return 'Medium';
        if (level < 6) return 'Hard';
        return 'Expert';
    }
    if (level === 1) return 'Easy';
    if (level === 2) return 'Medium';
    return 'Hard';
}

function openLab() {
    if (!currentLab) return;

    let port;
    if (currentLab.type === 'ssrf') {
        port = 8080 + currentLab.level;
    } else if (currentLab.type === 'ssti') {
        port = 8086 + currentLab.level;
    } else if (currentLab.type === 'csti') {
        port = 8089 + currentLab.level;
    }

    const hostname = window.location.hostname;
    const url = `http://${hostname}:${port}/`;

    document.getElementById('lab-display').style.display = 'none';
    document.getElementById('lab-iframe-container').style.display = 'block';
    document.getElementById('lab-frame').src = url;
}

