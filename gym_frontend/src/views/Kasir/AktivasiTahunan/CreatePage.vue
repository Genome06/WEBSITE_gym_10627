<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>TAMBAH AKTIVASI TAHUNAN</h4>
                        <hr />
                        <form @submit.prevent="store">
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Nama Member</label>
                                <select class="form-control" v-model="aktivasi.id_member">
                                    <option selected disabled value="">Pilih Member</option>
                                    <option v-for="member in members" :key="member.id" :value="member.id">{{ member.nama }}</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.id_member" class="mt-2 alert alert-danger">
                                    {{ validation.id_member[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Tanggal Aktivasi</label>
                                <input type="datetime-local" class="form-control" v-model="aktivasi.waktu"
                                    placeholder="Masukkan Tanggal"/>
                                <!-- validation -->
                                <div v-if="validation.waktu" class="mt-2 alert alert-danger">
                                    {{ validation.waktu[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Masa Aktif Aktivasi</label>
                                <input type="datetime-local" class="form-control" v-model="aktivasi.masa_aktif"
                                    placeholder="Masukkan Tanggal"/> 
                                <div v-if="validation.waktu" class="mt-2 alert alert-danger">
                                    {{ validation.waktu[0] }}
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
    //import moment from "moment"
    import axios from "axios";
    import { useToast } from "vue-toastification";
    export default {
        setup() {
            //state user
            const aktivasi = reactive({
                id_member: "",
                waktu: "",
                masa_aktif: "",
            });
            //state validation
            const validation = ref([]);
            //vue router
            const router = useRouter();

            let members = ref([])
            const kasir_id = localStorage.getItem('id')
            //mounted
            onMounted(() => {
                //get API from Laravel Backend
                axios.get('http://localhost:8000/api/members').then(response => {
                    //assign state posts with response data
                    members.value = response.data.data
                }).catch(error => {
                    console.log(error.response.data)
                })
            })


            function store() {
                let id_member = aktivasi.id_member;
                let biaya_aktivasi = 3000000;
                let waktu = aktivasi.waktu;
                //const date1 = new Date(waktu);
                let masa_aktif = aktivasi.masa_aktif;
                //const masa_aktif = moment(date1).add(365, 'd');
                //let masa_aktif = "2024-05-09"
                let no_aktivasi = "AKT-001";
                let toast = useToast();
                const token = localStorage.getItem('token')
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
                axios
                    .post("http://localhost:8000/api/aktivasiTahunan", {
                        id_member : id_member,
                        biaya_aktivasi : biaya_aktivasi,
                        waktu : waktu,
                        masa_aktif : masa_aktif,
                        no_aktivasi : no_aktivasi,
                        id_kasir : kasir_id
                    })
                    .then(() => {

                        toast.success("Berhasil Tambah Data !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "kasir.aktivasiTahunan.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data
                    });
            }
            //return
            return {
                aktivasi,
                members,
                validation,
                router,
                store,
            };
        },
    };

</script>
<style>

</style>