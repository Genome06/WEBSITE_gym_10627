<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST IZIN INSTRUKTUR</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Instruktur</th>
                                    <th scope="col">Alasan Izin</th>
                                    <th scope="col">Tanggal Izin</th>
                                    <th scope="col">Instruktur Pengganti</th>
                                    <th scope="col">Status Izin</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(instruktur, id) in instruktur" :key="id" class="text-center">
                                    <td>{{ instruktur.instruktur.nama }}</td>
                                    <td>{{ instruktur.alasan_izin }}</td>
                                    <td>{{ instruktur.tanggal_izin }}</td>
                                    <td>{{ instruktur.instruktur_pengganti.nama }}</td>
                                    <td v-if="instruktur.status_izin=='1'">Sudah Dikonfirmasi</td>
                                    <td v-else>Belum Dikonfirmasi</td>
                                    <td v-if="instruktur.status_izin=='1'" class="text-center">
                                        <button @click.prevent="instrukturUpdate(instruktur.id)" class="btn btn-md btn-success mb-4" disabled>KONFIRMASI IZIN</button>
                                    </td>
                                    <td v-else class="text-center">
                                        <button @click.prevent="instrukturUpdate(instruktur.id)" class="btn btn-md btn-success mb-4" >KONFIRMASI IZIN</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useRouter} from "vue-router";
import { useToast } from "vue-toastification";
export default {
    setup() {
        let instruktur = ref([])
        //let searchQuery = ref([])
        //state validation
        const validation = ref([]);
            //vue router
            const router = useRouter();
            //params id
        const token = localStorage.getItem('token')
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/IzinInstruktur')
            .then(response => {
                instruktur.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })

        /*function search(){
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/instrukturSearch', {
                params: {
                    query : searchQuery.value
                }
            }).then(response => {
                instruktur.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/

        function instrukturUpdate(id) {
                let status = 1;
                let toast = useToast();
                axios
                    .put("http://localhost:8000/api/IzinInstrukturStatus/" + id, {
                        status_izin : status
                    })
                    .then(() => {
                        toast.success("Berhasil Konfirmasi Izin !",{
                            timeout: 2000
                        })
                        //redirect ke post index
                        router.push({
                            name: "mo.izin.index",
                        });
                    })
                    .catch((error) => {
                        //assign state validation with error
                        validation.value = error.response.data;
                    });
            }

        //method delete
        /*function instrukturDelete(id) {
            axios.delete(`http://localhost:8000/api/instruktur/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                    instruktur.value.splice(instruktur.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }*/
        return {
            instruktur,
            instrukturUpdate
            //searchQuery,
            //instrukturDelete,
            //search
        }
    }
}
</script>
<style>
</style>