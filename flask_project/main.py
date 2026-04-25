from flask import Flask, redirect, session, flash, render_template
import mysql.connector

app = Flask(__name__)
def db_connect():
    return mysql.connector.connect(
        host="localhost",
        user="admin",
        password="1234",
        database="test"
    )

@app.route("/admin")
def show_user():
    # db = db_connect()
    # cursor = db.cursor(dictionary=True)
    # cursor.execute("SELECT * FROM users")
    # data = cursor.fetchall()
    # cursor.close()
    # db.close()
    return render_template("admin/create_teams.html")

@app.route("/admin/allow/<int:user_id>", methods=["POST"])
def allow_user(user_id):
    db = db_connect()
    cursor = db.cursor()
    cursor.execute("SELECT id FROM users WHERE id = %s", (user_id,))
    user = cursor.fetchone()

    if not user:
        cursor.close()
        db.close()
        flash("User not found", "danger")
        return redirect("/admin")

    cursor.execute("UPDATE users SET status = %s WHERE id = %s", ("active", user_id))
    db.commit()
    cursor.close()
    db.close()

    flash("User allowed successfully", "success")
    return redirect("/admin")


@app.route("/admin/ban/<int:user_id>", methods=["POST"])
def ban_user(user_id):
    db = db_connect()
    cursor = db.cursor()
    cursor.execute("SELECT id FROM users WHERE id = %s", (user_id,))
    user = cursor.fetchone()

    if not user:
        cursor.close()
        db.close()
        flash("User not found", "danger")
        return redirect("/admin")

    cursor.execute("UPDATE users SET status = %s WHERE id = %s", ("banned", user_id))
    db.commit()
    cursor.close()
    db.close()

    flash("User banned successfully", "success")
    return redirect("/admin")

if __name__ == "__main__":
    app.run(debug=True)