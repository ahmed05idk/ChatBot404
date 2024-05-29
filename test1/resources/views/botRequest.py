from flask import Flask, jsonify, request, make_response
from flask_cors import CORS
import openai

app = Flask(__name__)
CORS(app)

openai.api_key = "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"

@app.route('/process_data', methods=['POST', 'OPTIONS'])
def askquestion():
    if request.method == 'OPTIONS':
        response = make_response()
        response.headers["Access-Control-Allow-Origin"] = "*"
        response.headers["Access-Control-Allow-Methods"] = "POST, OPTIONS"
        response.headers["Access-Control-Allow-Headers"] = "Content-Type"
        return response

    data = request.json
    question = data['domanda']
    response_text = send_to_chatgpt(question, "Sei un professore universitario")

    toReturn = make_response(jsonify({'output': response_text}), 200)
    toReturn.headers["Content-Type"] = "application/json"
    toReturn.headers["Access-Control-Allow-Origin"] = "*"
    return toReturn

def send_to_chatgpt(text, sysPrompt):
    model = "gpt-3.5-turbo"
    prompt1 = sysPrompt
    messages1 = [{"role": "system", "content": prompt1}]
    messages1.append({"role": "user", "content": text})

    response = openai.ChatCompletion.create(
        model=model,
        messages=messages1
    )

    return response['choices'][0]['message']['content'].strip()

if __name__ == '__main__':
    app.run(debug=True)
