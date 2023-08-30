<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>TAMBAH MEMBER</h4>
                        <hr />
                        <form @submit.prevent="store">
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
                                    placeholder="Masukkan password member" />
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
                                <div v-if="validation.alamat" class="mt-2 alert alert-danger">
                                    {{ validation.alamat[0] }}
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
                                <div v-if="validation.jenis" class="mt-2 alert alert-danger">
                                    {{ validation.jenis[0] }}
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
    import { reactive, ref} from "vue";
    import { useRouter } from "vue-router";
    import axios from "axios";
    import { useToast } from "vue-toastification";
    export default {
        setup() {
            //state user
            const member = reactive({
                nama: "",
                username: "",
                password: "",
                no_hp: "",
                alamat: "",
                status:'',
                sisa_deposit_uang: 0
            });
            //state validation
            const validation = ref([]);
            //vue router
            const router = useRouter();

            function store() {
                let nama = member.nama;
                let username = member.username;
                let password = member.password;
                let no_hp = member.no_hp;
                let alamat = member.alamat;
                let sisa_deposit_uang = member.sisa_deposit_uang;
                let status = member.status;
                let toast = useToast();
                const token = localStorage.getItem('token')
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
                axios
                    .post("http://localhost:8000/api/members", {
                        nama: nama,
                        username: username,
                        password: password,
                        no_hp: no_hp,
                        alamat: alamat,
                        sisa_deposit_uang: sisa_deposit_uang,
                        status: status,
                    })
                    .then(() => {
                        toast.success("Berhasil Tambah Data !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "kasir.member.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data
                    });
            }
            //return
            return {
                member,
                validation,
                router,
                store,
            };
        },
    };

</script>
<style>

</style>