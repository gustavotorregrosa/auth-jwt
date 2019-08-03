def index():
    return dict()

def teste2():
    minharequest = request.vars
    meuJson = {
        'nome': 'gustavo torregrosa',
        'minharequest': minharequest
    }
    return response.json(meuJson)

