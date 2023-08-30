<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h4>TAMBAH DEPOSIT UANG</h4>
                        <hr />
                        <form @submit.prevent="store">
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Nama Member</label>
                                <select class="form-control" v-model="deposit.id_member">
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
                                <input type="datetime-local" class="form-control" v-model="deposit.waktu"
                                    placeholder="Masukkan Tanggal"/>
                                <!-- validation -->
                                <div v-if="validation.waktu" class="mt-2 alert alert-danger">
                                    {{ validation.waktu[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Biaya Deposit</label>
                                <input class="form-control" v-model="deposit.biaya_deposit"
                                    placeholder="Masukkan Biaya Deposit" />
                                <!-- validation -->
                                <div v-if="validation.biaya_deposit" class="mt-2 alert alert-danger">
                                    {{ validation.biaya_deposit[0] }}
                                </div>
                            </div>
                            <div class="form-group mb-13">
                                <label for="content" class="form-label">Bonus Deposit Uang</label>
                                <select class="form-control" v-model="deposit.id_promo">
                                    <option selected disabled value="">Pilih Bonus</option>
                                    <option v-for="promo in promos" :key="promo.id" :value="promo.id">{{ promo.potongan_promo }}</option>
                                </select>
                                <!-- validation -->
                                <div v-if="validation.id_promo" class="mt-2 alert alert-danger">
                                    {{ validation.id_promo[0] }}
                                </div>
                            </div>
                            <h1></h1>
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
            const deposit = reactive({
                id_member: "",
                waktu: "",
                biaya_deposit : "",
                id_promo : ""
            });
            //state validation
            const validation = ref([]);
            //vue router
            const router = useRouter();

            let members = ref([])
            let promos = ref([])
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

            //mounted
            onMounted(() => {
                //get API from Laravel Backend
                axios.get('http://localhost:8000/api/promo').then(response => {
                    //assign state posts with response data
                    promos.value = response.data.data
                }).catch(error => {
                    console.log(error.response.data)
                })
            })


            function store() {
                let id_member = deposit.id_member;
                let biaya_aktivasi = deposit.biaya_deposit;
                let waktu = deposit.waktu;
                //const date1 = new Date(waktu);
                let id_promo = deposit.id_promo;
                //const masa_aktif = moment(date1).add(365, 'd');
                //let masa_aktif = "2024-05-09"
                //let sisa_deposit_uang = biaya_aktivasi + members.value.sisa_deposit_uang + promos.value.potongan_promo
                let no_aktivasi = "AKT-001";
                let toast = useToast();
                const token = localStorage.getItem('token')
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
                axios
                    .post("http://localhost:8000/api/depositUang", {
                        id_member : id_member,
                        biaya_deposit : biaya_aktivasi,
                        waktu : waktu,
                        id_promo : id_promo,
                        no_deposit : no_aktivasi,
                        id_kasir : kasir_id
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
                promos,
                deposit,
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