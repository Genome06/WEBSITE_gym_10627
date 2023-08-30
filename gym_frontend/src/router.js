import {
    createRouter,
    createWebHistory
} from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'welcome',
        component: () => import('@/components/WelcomePage.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('@/components/LoginPage.vue'),
    },

    {
        path: '/admin',
        name: 'admin.beranda',
        component: () => import('@/components/AdminDashboard.vue'),
        children: [            
            {
                path: "/adminInstruktur",
                name: "admin.instruktur.index",
                component: () => import("@/views/Admin/Instruktur/IndexPage.vue"),
            },
            {
                path: "/adminInstruktur",
                name: "admin.instruktur.create",
                component: () => import("@/views/Admin/Instruktur/CreatePage.vue"),
            },
            {
                path: "/adminInstruktur",
                name: "admin.instruktur.edit",
                component: () => import("@/views/Admin/Instruktur/EditPage.vue"),
            },
            {
                path: "/adminPromo",
                name: "admin.promo.index",
                component: () => import("@/views/Admin/Promo/IndexPage.vue"),
            },
            {
                path: "/adminPegawai",
                name: "admin.pegawai.index",
                component: () => import("@/views/Admin/Pegawai/IndexPage.vue"),
            },
        ],
    },
    {
        path: '/mo',
        name: 'mo.beranda',
        component: () => import('@/components/MoDashboard.vue'),
        children: [            
            {
                path: "/moJadwal",
                name: "mo.jadwal.index",
                component: () => import("@/views/Mo/Jadwal/IndexPage.vue"),
            },
            {
                path: "/moJadwal",
                name: "mo.jadwal.create",
                component: () => import("@/views/Mo/Jadwal/CreatePage.vue"),
            },
            {
                path: "/moJadwal",
                name: "mo.jadwal.edit",
                component: () => import("@/views/Mo/Jadwal/EditPage.vue"),
            },
            {
                path: "/moJadwalHarian",
                name: "mo.jadwal_harian.index",
                component: () => import("@/views/Mo/JadwalHarian/IndexPage.vue"),
            },
            {
                path: "/moJadwalHarian",
                name: "mo.jadwal_harian.edit",
                component: () => import("@/views/Mo/JadwalHarian/EditPage.vue"),
            },
            {
                path: "/moKelas",
                name: "mo.kelas.index",
                component: () => import("@/views/Mo/Kelas/IndexPage.vue"),
            },
            {
                path: "/moIzin",
                name: "mo.izin.index",
                component: () => import("@/views/Mo/IzinInstruktur/IndexPage.vue"),
            },
            {
                path: "/moLaporan",
                name: "mo.laporan.index",
                component: () => import("@/views/Mo/Laporan/IndexPage.vue"),
            },
        ],
    },
    {
        path: '/kasir',
        name: 'kasir.beranda',
        component: () => import('@/components/KasirDashboard.vue'),
        children: [            
            {
                path: "/kasirMember",
                name: "kasir.member.index",
                component: () => import("@/views/Kasir/Member/IndexPage.vue"),
            },
            {
                path: "/kasirMember",
                name: "kasir.member.create",
                component: () => import("@/views/Kasir/Member/CreatePage.vue"),
            },
            {
                path: "/kasirMember",
                name: "kasir.member.edit",
                component: () => import("@/views/Kasir/Member/EditPage.vue"),
            },
            {
                path: "/kasirResetPassword",
                name: "kasir.reset.index",
                component: () => import("@/views/Kasir/ResetPassword/IndexPage.vue"),
            },
            {
                path: "/kasirResetPassword",
                name: "kasir.reset.resetPass",
                component: () => import("@/views/Kasir/ResetPassword/ResetPasswordPage.vue"),
            },
            {
                path: "/kasirAktivasi",
                name: "kasir.aktivasiTahunan.index",
                component: () => import("@/views/Kasir/AktivasiTahunan/IndexPage.vue"),
            },
            {
                path: "/kasirAktivasi",
                name: "kasir.aktivasiTahunan.create",
                component: () => import("@/views/Kasir/AktivasiTahunan/CreatePage.vue"),
            },
            {
                path: "/kasirDeposit",
                name: "kasir.depositUang.index",
                component: () => import("@/views/Kasir/DepositUang/IndexPage.vue"),
            },
            {
                path: "/kasirDeposit",
                name: "kasir.depositUang.create",
                component: () => import("@/views/Kasir/DepositUang/CreatePage.vue"),
            },
            {
                path: "/kasirDeposit",
                name: "kasir.booking_gym.index",
                component: () => import("@/views/Kasir/BookingGym/IndexPage.vue"),
            },
            {
                path: "/kasirDeposit",
                name: "kasir.booking_gym.edit",
                component: () => import("@/views/Kasir/BookingGym/EditPage.vue"),
            },
            {
                path: "/kasirDeposit",
                name: "kasir.booking_kelas.index",
                component: () => import("@/views/Kasir/BookingKelas/IndexPage.vue"),
            },
        ],
    },
]
//create router
const router = createRouter({
    history: createWebHistory(),
    routes // config routes
})
export default router;