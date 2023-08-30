<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST KELAS</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <router-link :to="{ name: '' }" class="btn btn-md btn-success mb-4">TAMBAH
                            KELAS</router-link>
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Kelas</th>
                                    <th scope="col">Jenis Kelas</th>
                                    <th scope="col">Harga Kelas</th>
                                    <th scope="col">Potongan Promo</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(kelas, id) in kelas" :key="id" class="text-center">
                                    <td>{{ kelas.nama_kelas }}</td>
                                    <td>{{ kelas.jenis_kelas }}</td>
                                    <td>{{ kelas.harga_kelas }}</td>
                                    <td>{{ kelas.promo.potongan_promo }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: '', params: { id: kelas.id } }" 
                                        class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        &nbsp;
                                        <button @click.prevent="kelasDelete(kelas.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
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
        let kelas = ref([])
        const token = localStorage.getItem('token')
        
        let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/kelas')
            .then(response => {
                kelas.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })
        //method delete
        function kelasDelete(id) {
            axios.delete(`http://localhost:8000/api/kelas/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        kelas.value.splice(kelas.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }
        return {
            kelas,
            kelasDelete
        }
    }
}
</script>
<style>
</style>