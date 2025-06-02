async function login(event) {
    event.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const rememberMe = document.getElementById("remember").checked;

    try {
        const res = await fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                email,
                password,
                remember_me: rememberMe,
            }),
        });

        if (!res.ok) throw new Error("Login gagal");

        const data = await res.json();

        localStorage.setItem("token", data.token);
        localStorage.setItem(
            "role",
            data.user.is_admin === 1 ? "admin" : "user"
        );

        alert("Login berhasil!");
        window.location.href = "/dashboard";
    } catch (err) {
        alert("Error: " + err.message);
    }
}
