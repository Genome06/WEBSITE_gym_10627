<template>
    <div class="d-flex justify-content-between flex-wrap flex-mdnowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">LIST MEMBER</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <router-link :to="{ name: 'kasir.member.create' }" class="btn btn-md btn-success mb-4">TAMBAH
                            MEMBER</router-link>
                            <div>
                                <button @click.prevent="search()" class="btn btn-sm btn-primary mr-1">Cari</button>
                                <input v-model="searchQuery" type="text" form="form-control" placeholder="Cari...."/>
                            </div>        
                        </div>       
                        <table class="table table-striped table-bordered mt4">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Nama Member</th>
                                    <th scope="col">Nomor Member</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Sisa Deposit Uang</th>
                                    <th scope="col">Telepon</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(member, id) in member" :key="id" class="text-center">
                                    <td>{{ member.nama }}</td>
                                    <td>ME-{{ member.id }}</td>
                                    <td>{{ member.username }}</td>
                                    <td v-if="member.status=='1'">Aktif</td>
                                    <td v-else>Tidak Aktif</td>
                                    <td>{{ member.sisa_deposit_uang }}</td>
                                    <td>{{ member.no_hp }}</td>
                                    <td>{{ member.alamat }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'kasir.member.edit', params: { id: member.id } }" 
                                        class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                        &nbsp;
                                        <button @click.prevent="memberDelete(member.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
                                        &nbsp;
                                        <button @click.prevent="deaktivasi(member.id)" class="btn btn-sm btn-danger ml-1">DEAKTIVASI</button>
                                        &nbsp;
                                        <button @click.prevent="" class="btn btn-info">CETAK</button>
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
import { useRouter} from "vue-router";
import { onMounted, ref } from 'vue'
import { useToast } from "vue-toastification";
export default {
    setup() {
        let member = ref([])
        const token = localStorage.getItem('token')
        const validation = ref([]);
            //vue router
            const router = useRouter();
        let searchQuery = ref([])

        let toast = useToast();
        onMounted(() => {
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/members')
            .then(response => {
                member.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
            
        })

        function search(){
            axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
            axios.get('http://localhost:8000/api/membersSearch', {
                params: {
                    query : searchQuery.value
                }
            }).then(response => {
                member.value = response.data.data
            }).catch(error => {
                console.log(error.response.data)
            })
        }
        //method delete
        function memberDelete(id) {
            axios.delete(`http://localhost:8000/api/members/${id}`)
            .then(() => {
                        toast.error("Berhasil Hapus Data !",{
                            timeout: 2000
                        })
                        member.value.splice(member.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function deaktivasi(id) {
                let status = 0;
                let toast = useToast();
                axios
                    .put("http://localhost:8000/api/membersStatus/" + id, {
                        status : status
                    })
                    .then(() => {
                        toast.success("Berhasil Deaktivasi Member !",{
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
        return {
            member,
            searchQuery,
            search,
            memberDelete,
            deaktivasi
        }
    }
}
</script>
<style>
</style>