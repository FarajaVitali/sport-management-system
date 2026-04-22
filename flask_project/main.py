from flask import Flask, redirect, session, flash,render_template
import mysql.connector

app = Flask(__name__)
app.secret_key = "secret"

def db_connect():
    return mysql.connector.connect(
        host="localhost",
        username="admin",
        password="1234",
        database="test"
    )

@app.route("/admin")
def show_user():
    db = db_connect()
    cursor = db.cursor(dictionary=True)
    cursor.execute("SELECT * FROM users")
    data = cursor.fetchall()
    cursor.close()

    return render_template("admin.html",users=data)

@app.route("/admin/allow/<int:user_id>", methods=["POST"])
def allow_user(user_id):
    if not session.get("is_admin"):
        return "Unauthorized", 403

    db = db_connect()
    cursor = db.cursor()
    cursor.execute("SELECT id FROM users WHERE id = %s", (user_id,))
    user = cursor.fetchone()

    if not user:
        cursor.close()
        flash("User not found", "danger")
        return redirect("/admin")

    cursor.execute("UPDATE users SET status = %s WHERE id = %s", ("active", user_id))
    mysql.connection.commit()
    cursor.close()

    flash("User allowed successfully", "success")
    return redirect("/admin")


@app.route("/admin/ban/<int:user_id>", methods=["POST"])
def ban_user(user_id):
    if not session.get("is_admin"):
        return "Unauthorized", 403

    db = db_connect()
    cursor = db.cursor()
    cursor.execute("SELECT id FROM users WHERE id = %s", (user_id,))
    user = cursor.fetchone()

    if not user:
        cursor.close()
        flash("User not found", "danger")
        return redirect("/admin")

    cursor.execute("UPDATE users SET status = %s WHERE id = %s", ("banned", user_id))
    mysql.connection.commit()
    cursor.close()

    flash("User banned successfully", "success")
    return redirect("/admin")

if __name__ == "__main__":
    app.run(debug=True)