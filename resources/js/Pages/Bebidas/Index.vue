<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    bebidas: Array,
    categorias: Array
});

const form = useForm({
    categoria_id: '',
    nombre: '',
    precio: '',
    imagen: null,
});

const submit = () => {
    form.post('/bebidas', {
        forceFormData: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div style="padding: 20px; font-family: sans-serif;">
        <h1>Gestión de Cafetería </h1>

        <div style="margin-bottom: 30px; padding: 20px; border: 1px solid #ccc;">
            <h3>Registrar Nueva Bebida</h3>
            <form @submit.prevent="submit">
                <select v-model="form.categoria_id" required style="margin-right: 10px;">
                    <option value="" disabled>Seleccionar Categoría</option>
                    <option v-for="cat in categorias" :key="cat.id" :value="cat.id">
                        {{ cat.nombre }}
                    </option>
                </select>

                <input type="text" v-model="form.nombre" placeholder="Nombre Bebida" required style="margin-right: 10px;" />
                <input type="number" step="0.10" v-model="form.precio" placeholder="Precio" required style="margin-right: 10px;" />
                
                <input type="file" @input="form.imagen = $event.target.files[0]" accept="image/*" style="margin-right: 10px;" />

                <button type="submit" style="padding: 5px 15px; background: #4CAF50; color: white; border: none;">Guardar</button>
            </form>
        </div>

        <table border="1" width="100%" cellpadding="10" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="bebida in bebidas" :key="bebida.id">
                    <td>{{ bebida.id }}</td>
                    <td>{{ bebida.categoria ? bebida.categoria.nombre : 'N/A' }}</td>
                    <td>{{ bebida.nombre }}</td>
                    <td>S/ {{ bebida.precio }}</td>
                    <td>
                        <img v-if="bebida.imagen" :src="`/storage/${bebida.imagen}`" width="80" alt="Foto bebida" />
                        <span v-else>Sin imagen</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>