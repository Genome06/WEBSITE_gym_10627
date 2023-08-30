<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>TAMBAH JADWAL</h4>
                        <hr />
                        <form @submit.prevent="store">
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Nama Kelas</label>
                                <select class="form-control" v-model="jadwalUmum.id_kelas">
                                    <option selected disabled value="">Pilih Kelas</option>
                                    <option v-for="kelas in kelass" :key="kelas.id" :value="kelas.id">{{ kelas.nama_kelas }}</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.id_kelas" class="mt-2 alert alert-danger">
                                    {{ validation.id_kelas[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Nama Instruktur</label>
                                <select class="form-control" v-model="jadwalUmum.id_instruktur">
                                    <option selected disabled value="">Pilih Instruktur</option>
                                    <option v-for="instruktur in instrukturs" :key="instruktur.id" :value="instruktur.id">{{ instruktur.nama }}</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.id_instruktur" class="mt-2 alert alert-danger">
                                    {{ validation.id_instruktur[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Hari</label>
                                <select class="form-control" v-model="jadwalUmum.waktu">
                                    <option selected disabled value="">Pilih Hari</option>
                                    <option value="1">Senin</option>
                                    <option value="2">Selasa</option>
                                    <option value="3">Rabu</option>
                                    <option value="4">Kamis</option>
                                    <option value="5">Jumat</option>
                                    <option value="6">Sabtu</option>
                                    <option value="7">Minggu</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.waktu" class="mt-2 alert alert-danger">
                                    {{ validation.waktu[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Jam</label>
                                <input type="time" class="form-control" v-model="jadwalUmum.waktu_hari"
                                    placeholder="Masukkan Jam"/>
                                <!-- validation -->
                                <div v-if="validation.waktu_hari" class="mt-2 alert alert-danger">
                                    {{ validation.waktu_hari[0] }}
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
    import { useRouter } from "vue-router";
    import axios from "axios";
    import { useToast } from "vue-toastification";
    export default {
        setup() {
            //state user
            const jadwalUmum = reactive({
                id_kelas: "",
                id_instruktur: "",
                waktu: "",
                waktu_hari : "",
            });
            //state validation
            const validation = ref([]);
            //vue router
            const router = useRouter();

            let kelass = ref([])
            let instrukturs = ref([])
            //mounted
            onMounted(() => {
                //get API from Laravel Backend
                axios.get('http://localhost:8000/api/kelas').then(response => {
                    //assign state posts with response data
                    kelass.value = response.data.data
                }).catch(error => {
                    console.log(error.response.data)
                })
            })

            onMounted(() => {
                //get API from Laravel Backend
                axios.get('http://localhost:8000/api/instruktur').then(response => {
                    //assign state posts with response data
                    instrukturs.value = response.data.data
                }).catch(error => {
                    console.log(error.response.data)
                })
            })

            function store() {
                let id_kelas = jadwalUmum.id_kelas;
                let id_instruktur = jadwalUmum.id_instruktur;
                let waktu = jadwalUmum.waktu;
                let waktu_hari = jadwalUmum.waktu_hari;
                let toast = useToast();
                const token = localStorage.getItem('token')
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
                axios
                    .post("http://localhost:8000/api/jadwalUmum", {
                        id_kelas : id_kelas,
                        id_instruktur : id_instruktur,
                        waktu : waktu,
                        waktu_hari : waktu_hari
                    })
                    .then(() => {
                        toast.success("Berhasil Tambah Data !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "mo.jadwal.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data
                    });
            }
            //return
            return {
                jadwalUmum,
                kelass,
                instrukturs,
                validation,
                router,
                store,
            };
        },
    };

</script>
<style>

</style>