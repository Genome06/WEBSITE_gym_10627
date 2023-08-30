<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>EDIT MEMBER</h4>
                        <hr />
                        <form @submit.prevent="update">
                            <div class="form-group mb-3">
                                <label class="form-label">Nama Member</label>
                                <input type="text" class="form-control" v-model="member.nama"
                                    placeholder="Masukkan nama member"/>
                                <!-- validation -->
                                <div v-if="validation.nama" class="mt-2 alert alert-danger">
                                    {{ validation.nama[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Username</label>
                                <input class="form-control" v-model="member.username"
                                    placeholder="Masukkan username member" />
                                <!-- validation -->
                                <div v-if="validation.username" class="mt-2 alert alert-danger">
                                    {{ validation.username[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Password Member</label>
                                <input class="form-control" v-model="member.password"
                                    placeholder="Masukkan password member"  disabled/>
                                <!-- validation -->
                                <div v-if="validation.password" class="mt-2 alert alert-danger">
                                    {{ validation.password[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Telepon Member</label>
                                <input class="form-control" v-model="member.no_hp"
                                    placeholder="Masukkan telepon member" />
                                <!-- validation -->
                                <div v-if="validation.no_hp" class="mt-2 alert alert-danger">
                                    {{ validation.no_hp[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Alamat Member</label>
                                <input class="form-control" v-model="member.alamat"
                                    placeholder="Masukkan alamat member" />
                                <!-- validation -->
                                <div v-if="validation.alamat" class="mt-2 alert alert-danger">
                                    {{ validation.alamat[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Sisa Deposit Uang</label>
                                <input class="form-control" v-model="member.sisa_deposit_uang"
                                    placeholder="Masukkan alamat member" />
                                <!-- validation -->
                                <div v-if="validation.sisa_deposit_uang" class="mt-2 alert alert-danger">
                                    {{ validation.sisa_deposit_uang[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Status</label>
                                <select class="form-control" v-model="member.status">
                                    <option value="" selected hidden disabled>Pilih Status Keaktifan Member</option>
                                    <option value='1'>Aktif</option>
                                    <option value='0'>Tidak Aktif</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.status" class="mt-2 alert alert-danger">
                                    {{ validation.status[0] }}
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
                nama: "",
                username: "",
                no_hp: "",
                alamat: "",
                status:'',
                sisa_deposit_uang: 0
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
                    member.username = response.data.data.username
                    member.no_hp = response.data.data.no_hp
                    member.alamat = response.data.data.alamat
                    member.sisa_deposit_uang = response.data.data.sisa_deposit_uang
                    member.status = response.data.data.status
                }).catch(error => {
                    console.log(error.response.data)
                })
            })

            function update() {
                let nama = member.nama;
                let username = member.username;
                let no_hp = member.no_hp;
                let alamat = member.alamat;
                let sisa_deposit_uang = member.sisa_deposit_uang;
                let status = member.status;
                let toast = useToast();
                axios
                    .put("http://localhost:8000/api/members/" + id, {
                        nama: nama,
                        username: username,
                        no_hp: no_hp,
                        alamat: alamat,
                        sisa_deposit_uang: sisa_deposit_uang,
                        status: status,
                    })
                    .then(() => {
                        toast.success("Berhasil Edit Data !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "kasir.member.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data;
                    });
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