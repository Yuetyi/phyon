from flask import Flask, jsonify

app = Flask(__name__)

@app.route("/ship_cost_api/<para1>/<para2>")
def process(para1, para2):
    try:
        num = int(para2)
    except ValueError:
        return jsonify({"result": "rejected", "reason": "Invalid number format"})

    cost = 300

    if para1 == "quantity":
        if num <= 30:
            cost += num * 60
            response_data = {"result": "accepted", "cost": cost}
        else:
            response_data = {"result": "rejected", "reason": "Maximum number of units per package is 30"}
    elif para1 == "weight":
        if num <= 70:
            cost += num * 50
            response_data = {"result": "accepted", "cost": cost}
        else:
            response_data = {"result": "rejected", "reason": "Maximum weight per package is 70kg"}
    else:
        response_data = {"result": "rejected", "reason": "Error: mode must be 'quantity' or 'weight'"}

    return jsonify(response_data)

if __name__ == "__main__":
    app.run(debug=True, host='127.0.0.1', port=8080)
