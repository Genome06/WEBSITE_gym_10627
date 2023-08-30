<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>EDIT INSTRUKTUR</h4>
                        <hr />
                        <form @submit.prevent="update">
                            <div class="form-group mb-3">
                                <label class="form-label">Nama Instruktur</label>
                                <input type="text" class="form-control" v-model="instruktur.nama"
                                    placeholder="Masukkan nama instruktur"/>
                                <!-- validation -->
                                <div v-if="validation.nama" class="mt-2 alert alert-danger">
                                    {{ validation.nama[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Username</label>
                                <input class="form-control" v-model="instruktur.username"
                                    placeholder="Masukkan username instruktur" />
                                <!-- validation -->
                                <div v-if="validation.username" class="mt-2 alert alert-danger">
                                    {{ validation.username[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Password Instruktur</label>
                                <input class="form-control" v-model="instruktur.password"
                                    placeholder="Masukkan password user" />
                                <!-- validation -->
                                <div v-if="validation.password" class="mt-2 alert alert-danger">
                                    {{ validation.password[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Telepon instruktur</label>
                                <input class="form-control" v-model="instruktur.no_hp"
                                    placeholder="Masukkan telepon instruktur" />
                                <!-- validation -->
                                <div v-if="validation.no_hp" class="mt-2 alert alert-danger">
                                    {{ validation.no_hp[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Alamat Instruktur</label>
                                <input class="form-control" v-model="instruktur.alamat"
                                    placeholder="Masukkan alamat instruktur" />
                                <!-- validation -->
                                <div v-if="validation.alamat" class="mt-2 alert alert-danger">
                                    {{ validation.alamat[0] }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive, ref, onMounted} from "vue";
    import { useRouter, useRoute } from "vue-router";
    import axios from "axios";
    import { useToast } from "vue-toastification";
    export default {
        setup() {
            //state user
            const instruktur = reactive({
                nama: "",
                username: "",
                password: "",
                no_hp: "",
                alamat: "",
            });
             //state validation
             const validation = ref([]);
            //vue router
            const router = useRouter();
            //params id
            const route = useRoute();
            const id = route.params.id
            const token = localStorage.getItem('token')

            onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            //get API from Laravel Backend
            axios
                .get("http://localhost:8000/api/instruktur/" + id,)
                .then(response => {
                    //assign state posts with response data
                    instruktur.nama = response.data.data.nama
                    instruktur.username = response.data.data.username
                    instruktur.password = response.data.data.password
                    instruktur.no_hp = response.data.data.no_hp
                    instruktur.alamat = response.data.data.alamat
                }).catch(error => {
                    console.log(error.response.data)
                })
            })

            function update() {
                let nama = instruktur.nama;
                let username = instruktur.username;
                let password = instruktur.password;
                let no_hp = instruktur.no_hp;
                let alamat = instruktur.alamat;
                let toast = useToast();
                axios
                    .put("http://localhost:8000/api/instruktur/" + id, {
                        nama: nama,
                        username: username,
                        password: password,
                        no_hp: no_hp,
                        alamat: alamat,
                    })
                    .then(() => {
                        toast.success("Berhasil Edit Data !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "admin.instruktur.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data;
                    });
            }
            //return
            return {
                instruktur,
                validation,
                router,
                update,
            };
        },
    };

</script>
<style>

</style>