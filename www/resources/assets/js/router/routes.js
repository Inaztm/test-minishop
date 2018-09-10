const Welcome = () => import('~/pages/welcome')
const Login = () => import('~/pages/auth/login')
const LoginToken = () => import('~/pages/auth/loginToken')
const Register = () => import('~/pages/auth/register')
const PasswordEmail = () => import('~/pages/auth/password/email')
const PasswordReset = () => import('~/pages/auth/password/reset')

const Settings = () => import('~/pages/settings/index')
const SettingsProfile = () => import('~/pages/settings/profile')
const SettingsPassword = () => import('~/pages/settings/password')

const Admin = () => import('~/pages/admin/index')
const AdminProducts = () => import('~/pages/admin/products')
const AdminOrders = () => import('~/pages/admin/orders')

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/login/:token', name: 'login.token', component: LoginToken },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/settings', component: Settings, children: [
    { path: '', redirect: { name: 'settings.profile' }},
    { path: 'profile', name: 'settings.profile', component: SettingsProfile },
    { path: 'password', name: 'settings.password', component: SettingsPassword }
  ] },

  { path: '/admin', component: Admin, children: [
    { path: '', redirect: { name: 'admin.products' }},
    { path: 'products', name: 'admin.products', component: AdminProducts },
    { path: 'orders', name: 'admin.orders', component: AdminOrders }
  ] },

  { path: '*', component: require('~/pages/errors/404') }
]
