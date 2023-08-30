<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST JADWAL UMUM</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <router-link :to="{ name: 'mo.jadwal.create' }" class="btn btn-md btn-success mb-4">TAMBAH
                            JADWAL</router-link>
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Hari</th>
                                    <th scope="col">Nama Instruktur</th>
                                    <th scope="col">Nama Kelas</th>
                                    <th scope="col">Jam</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(jadwal, id) in jadwal" :key="id" class="text-center">
                                    <td v-if="jadwal.waktu=='1'">Senin</td>
                                    <td v-else-if="jadwal.waktu=='2'">Selasa</td>
                                    <td v-else-if="jadwal.waktu=='3'">Rabu</td>
                                    <td v-else-if="jadwal.waktu=='4'">Kamis</td>
                                    <td v-else-if="jadwal.waktu=='5'">Jumat</td>
                                    <td v-else-if="jadwal.waktu=='6'">Sabtu</td>
                                    <td v-else>Minggu</td>
                                    <td>{{ jadwal.instruktur.nama }}</td>
                                    <td>{{ jadwal.kelas.nama_kelas }}</td>
                                    <td>{{ jadwal.waktu_hari }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'mo.jadwal.edit', params: { id: jadwal.id } }" 
                                        class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        &nbsp;
                                        <button @click.prevent="jadwalDelete(jadwal.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
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
import { useToast } from "vue-toastification";
export default {
    setup() {
        let jadwal = ref([])
        const token = localStorage.getItem('token')
        
        let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/jadwalUmum')
            .then(response => {
                jadwal.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })
        //method delete
        function jadwalDelete(id) {
            axios.delete(`http://localhost:8000/api/jadwalUmum/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        jadwal.value.splice(jadwal.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        
        /*function formatDate(date, dateType){
                const date1 = new Date(date);
                if (dateType === "fullDate") {
                     return moment(date1).format("D MMMM YYYY");
                }
        }*/
        return {
            jadwal,
            jadwalDelete
        }
    }
}
</script>
<style>
</style>