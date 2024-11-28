function insertCredential() {
    document.getElementById('username').value = 'root';
    document.getElementById('password').value = 'password';
}
document.getElementById('login-button').addEventListener('click', async function () {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const url = "http://localhost:8000/api/user-profile";
    let bearerToken;

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username, password }),
        });

        if (!response.ok) {
            throw new Error('Invalid credentials');
        }

        const data = await response.json();
        localStorage.setItem('token', data.data.token);
        bearerToken =  localStorage.getItem('token');
        const locResponse = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json',
                    }
                });
                if (locResponse.ok)
                {
                    window.location.href = '/bearer';
                }
        // Reindirizza alla dashboard
    } catch (error) {
        console.error(error);
        document.getElementById('login-error').style.display = 'block';
    }
});
