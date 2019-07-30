let meuApp = new Vue({
    el: '#meuApp',
    data: {
        apiurl: 'http://jwt-backend.test/api/',
        usuario: '',
        usuariologin: {},
        usuarioregistro: {}
    },
    computed: {
        estaLogado: function () {
            if (this.usuario) {
                return true;
            }
            return false;
        }
    },
    methods: {
        mounted: function () {
            this.usuario = localStorage.getItem('meuUsuario')
        },
        logout: function () {
            alert("logout")
        },
        login: function () {
            opcoes = {
                url: this.apiurl + 'usuario/login',
                method: 'post',
                body: JSON.stringify(this.usuariologin),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }

            fetch(opcoes.url, opcoes).then(resp => {
                if (resp.status == 200) {
                    resp.then(r => r.json()).then(conteudo => {
                        console.log(conteudo)
                        this.usuario = conteudo.usuario
                        localStorage.setItem('meuJwt', conteudo.jwt)
                        localStorage.setItem('meuUsuario', conteudo.usuario)
                        this.limparRegistros()

                    })
                }else{
                    throw new Error('Usuario/ senha errados')
                }
            })
        },
        limparRegistros: function () {
            this.usuariologin = ''
            this.usuarioregistro = ''
        },

        registrar: function () {
            opcoes = {
                url: this.apiurl + 'usuario/criar',
                method: 'post',
                body: JSON.stringify(this.usuarioregistro),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }
            fetch(opcoes.url, opcoes).then(resp => resp.json()).then(resp => {
                this.usuario = resp.usuario
                localStorage.setItem('meuJwt', resp.jwt)
                localStorage.setItem('meuUsuario', resp.usuario)
                this.limparRegistros()
            })
        },

        listarItens: async function () {
            opcoes = {
                url: this.apiurl + 'lista-itens',
                method: 'get'
            }

            let resposta = await jwtFetch(opcoes)
            console.log(resposta)
        }


    }
})


function gerarObjRequest(opcoes) {
    let jwt = localStorage.getItem("meuJwt")
    if(jwt){
        let myHeaders = new Headers
        myHeaders.set("jwt", jwt)
        opcoes.headers = myHeaders
    }
    return new Request(opcoes.url, opcoes)

}

function jwtFetch(opcoes) {
    function jwtFetchUnit(requestParam) {
        return new Promise((success, reject) => {
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
            return jwtFetchUnit(gerarObjRequest(opcoes)).then(resp => resp)
        }
        return result
    })

}

function abrirModalLogin() {
    let elem = document.querySelector('#modal1');
    let instance = M.Modal.getInstance(elem);
    instance.open();

}



document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});
});
