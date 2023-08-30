<template>
    <div class="wrapper">
        <div class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            GOFIT
        </div>
        <div v-if="loginFailed" class="alert alert-danger">
            Username atau Password Anda salah.
        </div>
        <form class="p-3 mt-3" @submit.prevent="login">
            <div class="form-group">
                <div class="form-field d-flex align-items-center">
                    <span class="far fa-user"></span>
                    <input v-model="user.username" class="form-control" placeholder="Username">
                </div>
                <div v-if="validation.username" class="mt-2 alert alert-danger">
                    {{ validation.username[0] }}
                </div>
                <div class="form-field d-flex align-items-center">
                    <span class="fas fa-key"></span>
                    <input type="password" v-model="user.password" class="form-control" placeholder="Password">
                </div>
                <div v-if="validation.password" class="mt-2 alert alert-danger">
                    {{ validation.password[0] }}
                </div>
                <button type="submit" class="btn mt-3">Login</button>
            </div>
            
        </form>
    </div>
</template>

<script>
    import { reactive, ref } from 'vue'
    import { useRouter } from 'vue-router'
    import axios from 'axios'
    import { useToast } from "vue-toastification";
    export default {
        setup() {
            //inisialisasi vue router on Composition API
            const router = useRouter()
            //state user
            const user = reactive({
                username: '',
                password: '',
            })
            //state validation
            const validation = ref([])
            //state loginFailed
            const loginFailed = ref(null)
            
            let toast = useToast();
            //method login
            function login() {
                //send server with axios
                axios
                    .post("http://localhost:8000/api/login", user)
                    .then((response) => {
                    if (response.data.success) {
                        toast.success("Berhasil Login !",{
                            timeout: 2000
                        })
                        //set token
                        localStorage.setItem("id", response.data.user.id);
                        localStorage.setItem("token", response.data.access_token);
                        //redirect ke halaman dashboard
                        if (response.data.user.jabatan === "Admin") {
                        router
                            .push({
                            name: "admin.instruktur.index",
                            })
                            
                        }else if (response.data.user.jabatan === "MO") {
                        router
                            .push({
                            name: "mo.jadwal.index",
                            })
                        }else if (response.data.user.jabatan === "Kasir") {
                        router
                            .push({
                            name: "kasir.member.index",
                            })
                        }
                    }
                    //set state loggedIn to true
                    })
                    .catch((error) => {
                        loginFailed.value = true
                    //set validation dari error response
                    validation.value = error.response.data;
                    });
            }
            return {
                user,           // <-- state user
                validation,     // <-- state validation 
                loginFailed,    // <-- state loggedIn
                login           // <-- method login
            }
        }
    }
</script>

<style>
    /* Importing fonts from Google */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
    /* Reseting */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    body {
        background: #ecf0f3;
    }
    .wrapper {
        max-width: 350px;
        min-height: 500px;
        margin: 80px auto;
        padding: 40px 30px 30px 30px;
        background-color: #ecf0f3;
        border-radius: 15px;
        box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
    }
    .logo {
        width: 80px;
        margin: auto;
    }
    .logo img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0px 0px 3px #5f5f5f,
            0px 0px 0px 5px #ecf0f3,
            8px 8px 15px #a7aaa7,
            -8px -8px 15px #fff;
    }
    .wrapper .name {
        font-weight: 600;
        font-size: 1.4rem;
        letter-spacing: 1.3px;
        padding-left: 10px;
        color: #555;
    }
    .wrapper .form-field input {
        width: 100%;
        display: block;
        border: none;
        outline: none;
        background: none;
        font-size: 1.2rem;
        color: #666;
        padding: 10px 15px 10px 10px;
        /* border: 1px solid red; */
    }
    .wrapper .form-field {
        padding-left: 10px;
        margin-bottom: 20px;
        border-radius: 20px;
        box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
    }
    .wrapper .form-field .fas {
        color: #555;
    }
    .wrapper .btn {
        box-shadow: none;
        width: 100%;
        height: 40px;
        background-color: #03A9F4;
        color: #fff;
        border-radius: 25px;
        box-shadow: 3px 3px 3px #b1b1b1,
            -3px -3px 3px #fff;
        letter-spacing: 1.3px;
    }
    .wrapper .btn:hover {
        background-color: #039BE5;
    }
    .wrapper a {
        text-decoration: none;
        font-size: 0.8rem;
        color: #03A9F4;
    }
    .wrapper a:hover {
        color: #039BE5;
    }
    @media(max-width: 380px) {
        .wrapper {
            margin: 30px 20px;
            padding: 40px 15px 15px 15px;
        }
    }
</style>