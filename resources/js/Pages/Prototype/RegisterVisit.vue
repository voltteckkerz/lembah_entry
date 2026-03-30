<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Register Visit - VMS Portal" />
    <div class="text-on-surface selection:bg-secondary-container selection:text-on-secondary-container font-body bg-surface min-h-screen">
        <!-- TopAppBar -->
        <header class="fixed top-0 w-full z-50 bg-stone-50/80 dark:bg-stone-950/80 backdrop-blur-xl shadow-sm flex justify-between items-center px-6 py-3 font-['Plus_Jakarta_Sans'] tracking-tight">
        <div class="flex items-center gap-4">
        <span class="text-xl font-bold text-red-950 dark:text-red-400">VMS Portal</span>
        </div>
        <div class="flex items-center gap-6">
        <div class="hidden md:flex items-center bg-stone-200/20 dark:bg-stone-800/20 px-4 py-1.5 rounded-full">
        <span class="material-symbols-outlined text-stone-500 text-sm mr-2">search</span>
        <input class="bg-transparent border-none focus:ring-0 text-sm w-48 text-on-surface" placeholder="Search visitors..." type="text"/>
        </div>
        <div class="flex items-center gap-4">
        <button class="p-2 rounded-full hover:bg-stone-100 dark:hover:bg-stone-900 transition-colors active:scale-95 duration-200">
        <span class="material-symbols-outlined text-stone-600">notifications</span>
        </button>
        <button class="p-2 rounded-full hover:bg-stone-100 dark:hover:bg-stone-900 transition-colors active:scale-95 duration-200">
        <span class="material-symbols-outlined text-stone-600">help_outline</span>
        </button>
        <div class="w-8 h-8 rounded-full overflow-hidden bg-surface-container-high ring-2 ring-primary/10">
        <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAHjZ0Nk_mrBeW_SXvO6EhOHf_Q9jvDqS1dfQCSwzU7ICn79_sQWzQA1U5wmwS89wgPC56KoUSciURllSolyhVk0q1RW6WiVqrPtyNBItLfdhZdXFdr7OviVVvad6JupIFxfwLK8Rta8ccuj_SV7GfWSozX7fCLiiiGv4jxnloNf-gGzngochq4f4yCBW7aG1SGYq75WFfOpFtHJsnUhwV5YFKt2waNGfYnsOY9KWVZAyCiRmosi_-3_4U2dt5BMI9XRxexVJpfUw1"/>
        </div>
        </div>
        </div>
        </header>
        <!-- SideNavBar -->
        <aside class="h-screen w-64 fixed left-0 top-0 bg-stone-100 dark:bg-stone-900 flex flex-col py-6 font-['Plus_Jakarta_Sans'] text-sm z-40">
        <div class="px-6 mb-10 flex flex-col gap-1">
        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mb-3">
        <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">vignette</span>
        </div>
        <h2 class="font-bold text-red-950 dark:text-red-400 text-lg leading-tight">Visitor Management</h2>
        <p class="text-stone-500 text-[10px] tracking-widest uppercase">The Earthbound Curator</p>
        </div>
        <nav class="flex-1 flex flex-col gap-1">
        <a class="flex items-center gap-3 px-6 py-3 text-stone-600 dark:text-stone-400 hover:bg-stone-200/30 dark:hover:bg-stone-800/30 transition-all duration-300 ease-in-out" href="#">
        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
        <a class="flex items-center gap-3 px-6 py-3 text-red-900 dark:text-red-400 font-bold border-r-4 border-red-900 dark:border-red-500 bg-stone-200/50 dark:bg-stone-800/50 transition-all duration-300 ease-in-out" href="#">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person_add</span>
                        Register Visit
                    </a>
        <a class="flex items-center gap-3 px-6 py-3 text-stone-600 dark:text-stone-400 hover:bg-stone-200/30 dark:hover:bg-stone-800/30 transition-all duration-300 ease-in-out" href="#">
        <span class="material-symbols-outlined">list_alt</span>
                        Visitor Logs
                    </a>
        <a class="flex items-center gap-3 px-6 py-3 text-stone-600 dark:text-stone-400 hover:bg-stone-200/30 dark:hover:bg-stone-800/30 transition-all duration-300 ease-in-out" href="#">
        <span class="material-symbols-outlined">badge</span>
                        Employees
                    </a>
        <a class="flex items-center gap-3 px-6 py-3 text-stone-600 dark:text-stone-400 hover:bg-stone-200/30 dark:hover:bg-stone-800/30 transition-all duration-300 ease-in-out" href="#">
        <span class="material-symbols-outlined">settings</span>
                        Settings
                    </a>
        </nav>
        <div class="px-6 mt-auto">
        <button class="w-full bg-gradient-to-br from-primary to-primary-container text-white py-3 rounded-lg font-semibold shadow-lg shadow-primary/20 active:scale-95 transition-transform mb-6">
                        Submit Visit
                    </button>
        <a class="flex items-center gap-3 py-3 text-stone-500 hover:text-primary transition-colors" href="#">
        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </a>
        </div>
        </aside>
        <!-- Main Content -->
        <main class="ml-64 pt-20 pb-12 px-8">
        <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="mb-10 flex items-end justify-between">
        <div>
        <h1 class="text-4xl font-extrabold text-primary tracking-tight mb-2 font-headline">Register Visit</h1>
        <p class="text-on-surface-variant max-w-lg">Fill in the details below to schedule a new visit. All information is stored securely following heritage protocol.</p>
        </div>
        <div class="hidden lg:block">
        <img class="rounded-xl object-cover editorial-shadow opacity-80 border-l-4 border-primary h-32" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRR7ZtWvqSUcExC-3XlYUtMjiWFjw1CfP6v3y2RAUx0Wq5muLXR2mHqlNwH0GbLv9xz2NCmNs7JZNXMcXXv8OShgwilKMJzkWa8lYsce8ThMsU00er81U8yBa_iug_1Ol-caa4QATGilqxU3_COxzE7hp5JtFrFlrXLO1F4LQ21tX0l8LXsY8JWE9D45E6dxGow_ggthCKEh2uyhPSlB0PQ2BwFVZRf7T0xcP3H2gtTC5LTlO1e72LYnGC-9ygRtQPSACPC9vJwXUe"/>
        </div>
        </div>
        <!-- Form Layout: Bento Grid Style -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <!-- Section 1: Visit Info & Vehicle -->
        <div class="md:col-span-4 flex flex-col gap-8">
        <!-- Visit Info Card -->
        <section class="bg-surface-container-low p-6 rounded-xl border-t border-white/40">
        <div class="flex items-center gap-2 mb-6">
        <span class="material-symbols-outlined text-primary text-xl">info</span>
        <h3 class="font-bold text-primary uppercase tracking-widest text-xs font-headline">Visit Info</h3>
        </div>
        <div class="space-y-5">
        <div>
        <label class="block text-xs font-bold text-on-surface-variant mb-2 ml-1">Purpose of Visit</label>
        <input class="w-full bg-surface-container-high border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all" placeholder="e.g. Maintenance, Delivery" type="text"/>
        </div>
        <div>
        <label class="block text-xs font-bold text-on-surface-variant mb-2 ml-1">Host Employee</label>
        <div class="relative">
        <select class="w-full bg-surface-container-high border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all appearance-none cursor-pointer">
        <option>Select Employee</option>
        <option>Ahmad Zulkifli (Sales)</option>
        <option>Sarah Tan (HR)</option>
        <option>Rajesh Kumar (Operations)</option>
        </select>
        <span class="material-symbols-outlined absolute right-3 top-3 pointer-events-none text-stone-400">expand_more</span>
        </div>
        </div>
        </div>
        </section>
        <!-- Vehicle Info Card (Optional) -->
        <section class="bg-surface-container-low p-6 rounded-xl border-t border-white/40">
        <div class="flex items-center gap-2 mb-6">
        <span class="material-symbols-outlined text-primary text-xl">directions_car</span>
        <h3 class="font-bold text-primary uppercase tracking-widest text-xs font-headline">Vehicle (Optional)</h3>
        </div>
        <div class="space-y-5">
        <div>
        <label class="block text-xs font-bold text-on-surface-variant mb-2 ml-1">Plate Number</label>
        <input class="w-full bg-surface-container-high border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all" placeholder="ABC 1234" type="text"/>
        </div>
        <div>
        <label class="block text-xs font-bold text-on-surface-variant mb-2 ml-1">Vehicle Type</label>
        <div class="relative">
        <select class="w-full bg-surface-container-high border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all appearance-none cursor-pointer">
        <option>Car</option>
        <option>Motorcycle</option>
        <option>Truck / Lorry</option>
        </select>
        <span class="material-symbols-outlined absolute right-3 top-3 pointer-events-none text-stone-400">expand_more</span>
        </div>
        </div>
        </div>
        </section>
        </div>
        <!-- Section 2: Visitors Dynamic List -->
        <div class="md:col-span-8 space-y-8">
        <section class="bg-surface-container-lowest editorial-shadow p-8 rounded-xl relative overflow-hidden">
        <!-- Decorative background texture -->
        <div class="absolute top-0 right-0 p-8 opacity-5">
        <span class="material-symbols-outlined text-[120px]">groups</span>
        </div>
        <div class="flex items-center justify-between mb-8 relative z-10">
        <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">group</span>
        <h3 class="text-xl font-bold text-primary font-headline">Visitors</h3>
        </div>
        <button class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/5 hover:bg-primary/10 px-4 py-2 rounded-lg transition-colors">
        <span class="material-symbols-outlined text-lg">add</span>
                                        Add Visitor
                                    </button>
        </div>
        <div class="space-y-4 relative z-10">
        <!-- Visitor Row 1 -->
        <div class="grid grid-cols-12 gap-4 items-end bg-surface-container-low/30 p-4 rounded-xl">
        <div class="col-span-6">
        <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2 ml-1">Full Name</label>
        <input class="w-full bg-surface-container-high border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all" placeholder="Enter visitor name" type="text"/>
        </div>
        <div class="col-span-5">
        <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-2 ml-1">IC / Passport Number</label>
        <input class="w-full bg-surface-container-high border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all" placeholder="900000-00-0000" type="text"/>
        </div>
        <div class="col-span-1 flex justify-center pb-2">
        <button class="text-stone-300 hover:text-error transition-colors">
        <span class="material-symbols-outlined">delete</span>
        </button>
        </div>
        </div>
        <!-- Visitor Row 2 (Placeholder example) -->
        <div class="grid grid-cols-12 gap-4 items-end p-4">
        <div class="col-span-6">
        <input class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all" placeholder="Enter visitor name" type="text"/>
        </div>
        <div class="col-span-5">
        <input class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all" placeholder="900000-00-0000" type="text"/>
        </div>
        <div class="col-span-1 flex justify-center pb-2">
        <button class="text-stone-300 hover:text-error transition-colors">
        <span class="material-symbols-outlined">delete</span>
        </button>
        </div>
        </div>
        </div>
        <div class="mt-8 pt-8 border-t border-stone-100 flex items-center justify-between text-on-surface-variant text-sm italic">
        <p>You can add up to 5 visitors per registration.</p>
        </div>
        </section>
        <!-- Section 3: Items (Optional) -->
        <section class="bg-surface-container-low p-8 rounded-xl">
        <div class="flex items-center gap-3 mb-6">
        <span class="material-symbols-outlined text-primary text-xl">inventory_2</span>
        <h3 class="font-bold text-primary uppercase tracking-widest text-xs font-headline">Items Carried (Optional)</h3>
        </div>
        <div class="overflow-x-auto">
        <table class="w-full text-left">
        <thead>
        <tr class="text-[10px] font-extrabold text-stone-400 uppercase tracking-widest border-b border-stone-200">
        <th class="pb-3 px-2">Item Name</th>
        <th class="pb-3 px-2 w-24">Qty</th>
        <th class="pb-3 px-2">Remarks</th>
        <th class="pb-3 px-2 w-10"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-stone-100">
        <tr>
        <td class="py-4 px-2">
        <input class="w-full bg-transparent border-none text-sm focus:ring-0 p-0 placeholder:text-stone-300" placeholder="Laptop, Toolbox etc." type="text"/>
        </td>
        <td class="py-4 px-2">
        <input class="w-16 bg-transparent border-none text-sm focus:ring-0 p-0" type="number" value="1"/>
        </td>
        <td class="py-4 px-2">
        <input class="w-full bg-transparent border-none text-sm focus:ring-0 p-0 placeholder:text-stone-300" placeholder="Company property" type="text"/>
        </td>
        <td class="py-4 px-2 text-right">
        <button class="text-stone-300 hover:text-error transition-colors"><span class="material-symbols-outlined text-sm">close</span></button>
        </td>
        </tr>
        <tr>
        <td class="py-4 px-2">
        <input class="w-full bg-transparent border-none text-sm focus:ring-0 p-0 placeholder:text-stone-300" placeholder="Add another item..." type="text"/>
        </td>
        <td class="py-4 px-2"></td>
        <td class="py-4 px-2"></td>
        <td class="py-4 px-2"></td>
        </tr>
        </tbody>
        </table>
        </div>
        </section>
        </div>
        </div>
        <!-- Global Actions -->
        <div class="mt-12 flex items-center justify-between border-t border-stone-200 pt-8">
        <div class="flex items-center gap-4">
        <button class="px-6 py-3 rounded-lg text-on-surface-variant font-bold text-sm hover:bg-stone-200 transition-colors">
                                Discard Draft
                            </button>
        <button class="px-6 py-3 rounded-lg bg-surface-container-highest text-on-surface font-bold text-sm hover:bg-surface-dim transition-colors">
                                Save for Later
                            </button>
        </div>
        <button class="group flex items-center gap-3 bg-gradient-to-br from-primary to-primary-container text-white px-10 py-4 rounded-xl font-bold editorial-shadow hover:scale-[1.02] active:scale-95 transition-all">
                            Submit Visit Registration
                            <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
        </button>
        </div>
        </div>
        </main>
        <!-- Floating Help Button -->
        <button class="fixed bottom-8 right-8 w-14 h-14 bg-secondary text-white rounded-full editorial-shadow flex items-center justify-center hover:bg-on-secondary-container transition-colors z-50">
        <span class="material-symbols-outlined">support_agent</span>
        </button>
    </div>
</template>

<style scoped>
.editorial-shadow {
    box-shadow: 0 20px 40px rgba(27, 28, 28, 0.06);
}
</style>
