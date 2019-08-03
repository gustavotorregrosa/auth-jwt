import hashlib 

def cadastrar():
    db.auth_user.insert(first_name = request.vars['nome'], last_name = request.vars['sobrenome'], password = hashlib.md5(request.vars['senha']))
    return 'OK'