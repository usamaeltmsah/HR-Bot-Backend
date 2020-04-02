from flask import Flask
import random
app = Flask(__name__)

@app.route("/<string:question>/<string:answer>")

def index(question, answer):
    # return f"Question is {question},  Answer is {answer}"
    evaluation = random.randint(0, 10)
    return f"{evaluation}"

if __name__ == "__main__":
    app.run(debug=True)