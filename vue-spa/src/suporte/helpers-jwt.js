

function gerarObjRequest(opcoes) {
    let jwt = localStorage.getItem("meuJwt")
    if (jwt) {
        let myHeaders = new Headers
        myHeaders.set("jwt", jwt)
        opcoes.headers = myHeaders
    }
    return new Request(opcoes.url, opcoes)

}

export function jwtFetch(opcoes) {
    function jwtFetchUnit(requestParam, delay = 0) {
        return new Promise((success, reject) => {
            setTimeout(() => {
                fetch(requestParam).then(response => {
                    if (response.status == 401) {
                        throw new Error("Usuário inválido")
                    }
                    if (response.status == 301) {
                        abrirModalLogin()
                        throw new Error("Você será redirecionado para o login")
                    }

                    let status = response.status
                    success(response.json().then(conteudo => {
                        return {
                            status,
                            conteudo
                        }
                    }))
                })
            }, delay)
        })
    }


    let fetchGarantido = new Promise((success, reject) => {
            jwtFetchUnit(gerarObjRequest(opcoes)).then(resp => success(resp))
    })

    return fetchGarantido.then((result) => {
        if (result.status == 203) {
            let objUsuario = result.conteudo
            localStorage.setItem('meuJwt', objUsuario.jwt)
            localStorage.setItem('meuUsuario', JSON.stringify(objUsuario.usuario))
            return jwtFetchUnit(gerarObjRequest(opcoes), 0).then(resp => resp)
        }
        return result
    })

}

