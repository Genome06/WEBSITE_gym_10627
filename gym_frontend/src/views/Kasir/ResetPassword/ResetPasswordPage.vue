<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>RESET PASSWORD MEMBER</h4>
                        <hr />
                        <form @submit.prevent="update">
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Password Member</label>
                                <input class="form-control" v-model="member.password"
                                    placeholder="Masukkan password baru"/>
                                <!-- validation -->
                                <div v-if="validation.password" class="mt-2 alert alert-danger">
                                    {{ validation.password[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Konfirmasi Password Baru</label>
                                <input class="form-control" v-model="member.passwordBaru"
                                    placeholder="konfirmasi"/>
                                <!-- validation -->
                                <div v-if="member.passwordBaru !== member.password" class="mt-2 alert alert-danger">
                                    {{ validation.password[0] }}
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
            const member = reactive({
                password : "",
                passwordBaru : ""
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
                .get("http://localhost:8000/api/members/" + id,)
                .then(response => {
                    //assign state posts with response data
                    member.nama = response.data.data.nama
                }).catch(error => {
                    console.log(error.response.data)
                })
            })

            function update() {
                let passwordBaru = member.passwordBaru;
                let password = member.password;
                let toast = useToast();
                if (passwordBaru==password) {
                    axios
                    .put("http://localhost:8000/api/membersResetPass/" + id, {
                       password : passwordBaru
                    })
                    .then(() => {
                        toast.success("Berhasil reset password !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "kasir.reset.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data;
                    });   
                }else{
                    toast.error("Konfirmasi Password Salah",{
                            timeout: 2000
                    })
                }
            }
            //return
            return {
                member,
                validation,
                router,
                update,
            };
        },
    };

</script>
<style>

</style>