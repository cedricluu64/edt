<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/46b3b76d85.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title> Note ton prof </title>
    <style>
        .selected{
            background-color: #9f9ce0;
            
        }
        .card{
            transition-duration: 0.4s;
            text-align: center;
        }
        .btn {
            transition-duration: 0.4s;
        }
        .btn:hover{
            background-color: #0000ff;
        }

    </style>
</head>

<body>
    <br><br>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios@0.26.0/dist/axios.min.js"></script>
    <div id="app" class="container">
        <div class="row">
            <div class="col">
                <h1>Note ton prof</h1>
                <div class="row">
                    <div v-for="professeur in professeurs" class="col-lg-5">
                        <div class="card mb-5">
                            <div class="card-body" :class="{'selected': professeur.id === professeurCourant?.id}">
                                <h5 class="card-title">{{ professeur.prenom + ' ' + professeur.nom }}</h5>
                                <p class="card-text">
                                    {{ professeur.email }} <br>
                                    <button @click="getAvis(professeur)" class="btn btn-primary mt-3">Afficher les avis <i class="fa fa-search" aria-hidden="true"></i></button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="professeurCourant" class="col-5">
            <h1> Saisir un avis pour <br> {{ professeurCourant.prenom + ' ' + professeurCourant.nom}} </h1>
            <p v-for="error in erreurs" style="color:red;"> {{error}}</p>
            <form class="mn-5 card" v-on:submit.prevent="creerAvis()">
                <div class="form-group">
                    <label>Note</label>

                    <select class="form-control" v-model="nouvelAvis.note">
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <div class="form-group">
                        <label>Commentaire</label>
                        <textarea class="form-control" v-model="nouvelAvis.commentaire" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Adresse email</label>
                        <input type="email" class="form-control" v-model="nouvelAvis.emailEtudiant" required>
                    </div>
                    <div class="form-group mt-1">
                        <input type="submit" class="btn btn-primary" style="width:100%" value="Ajouter un avis" />
                    </div>
                </div>
            </form>
        </div>
        </div>
        <div v-if="professeurCourant" class="col">
            <h2>Avis concernant {{ professeurCourant.prenom + ' ' + professeurCourant.nom }}</h2>
            <div class="row">
                <div v-for="(item, index) in avis" class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ 'Note: ' + item.note }}</h5>
                            <p class="card-text">{{ item.commentaire }}</p>
                            <p class="card-footer">{{ 'Avis de ' + item.emailEtudiant }}</p>
                            <button class="btn btn-primary" @click="supprAvis(item.id, index)" style="width:50%;background:#fc2803;color:black"><i class="fa fa-trash"></i></button>
                            <button class="btn btn-primary" @click="modifAvis(item.id, index)" style="width:50%;background:#fcdf03;color:black"><i class="fa fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>

<script>
    Vue.createApp({
        data() {
            return {
                message: 'Hello Vue!',
                professeurs: [],
                avis: [],
                professeurCourant: null,
                nouvelAvis: {
                    note: 0,
                    commentaire: '',
                    emailEtudiant: ''
                },
                erreurs:[]
            }
        },
        mounted() {
            this.getProfesseurs();
        },
        methods: {
            getProfesseurs() {
                axios.get('http://localhost:8667/api/professeurs').then((resp) => {
                    console.log(resp)
                    this.professeurs = resp.data;
                }).catch((err) => {
                    this.erreurs.push(err);
                });
            },
            resetAvis: function() {
                return {
                    note: 0,
                    commentaire: '',
                    emailEtudiant: ''
                }
            },
            getAvis(professeur) {
                this.professeurCourant = professeur
                this.nouvelAvis = this.resetAvis()
                axios.get('http://localhost:8667/api/professeurs/' + professeur.id + '/avis').then((resp) => {
                    console.log(resp)
                    this.avis = resp.data;
                }).catch((err) => {
                    console.warn(err);
                })
            },
            creerAvis: function() {
                axios.post('http://localhost:8667/api/professeurs/' + this.professeurCourant.id + '/avis', this.nouvelAvis).then((resp) => {
                    this.avis.push(resp.data);
                    this.nouvelAvis = this.resetAvis()
                }).catch((err) => {
                    this.erreurs = Object.values(err.response.data.Message)

                })
            },
            supprAvis(id, index) {
                axios.delete('http://localhost:8667/api/professeurs/avis/'+ id).then((resp) => {
                    this.avis.splice(index,1)
                }).catch((err) => {
                    console.warn(err);
                })
            },
            modifAvis(id, index) {
                axios.patch('http://localhost:8667/api/professeurs/avis/'+ id).then((resp) => {
                    this.avis.splice(index,1)
                }).catch((err) => {
                    console.warn(err);
                })
            }

        },
    }).mount('#app')
</script>

</html>