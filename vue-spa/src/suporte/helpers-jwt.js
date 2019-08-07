export function pJwtFetch(opcoes) {

    function gerarObjRequest(opcoes) {
        let jwt = localStorage.getItem("meuJwt")
        if (jwt) {
            let myHeaders = new Headers
            myHeaders.set("jwt", jwt)
            opcoes.headers = myHeaders
        }
        return new Request(opcoes.url, opcoes)
    }

    function jwtFetchUnit(requestParam) {
        return new Promise((success, reject) => {
            fetch(requestParam).then(response => {
                if (![200, 203].includes(response.status)) {
                    reject(response.status)
                }
                let status = response.status
                success(response.json().then(conteudo => {
                    return {
                        status,
                        conteudo
                    }
                }))
            })
        })
    }



    let fetchGarantido = new Promise((success, reject) => {
        jwtFetchUnit(gerarObjRequest(opcoes)).then(resp => success(resp)).catch(status => reject(status))
    })


    return new Promise((success, reject) => {
        fetchGarantido.then((result) => {
            if(result.status == 203) {
                let objUsuario = result.conteudo
                localStorage.setItem('meuJwt', objUsuario.jwt)
                localStorage.setItem('meuUsuario', JSON.stringify(objUsuario.usuario))
                jwtFetchUnit(gerarObjRequest(opcoes)).then(resp => success(resp.conteudo))
            }
            success(result.conteudo)
        }).catch(status => reject(status))
    })

}


