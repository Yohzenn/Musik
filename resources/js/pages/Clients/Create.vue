<template>
    <MusicLayout>
        <template #title>
            Créer un client
        </template>

        <template #actions>
            <Link :href="clientsIndex().url">
                <Button variant="outline">
                    Retour
                </Button>
            </Link>
        </template>

        <template #content>
            <ClientForm />
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import ClientForm from '@/components/Clients/ClientForm.vue';
import { index as clientsIndex } from '@/routes/clients';

export default {
    name: 'ClientsCreate',
    components: {
        MusicLayout,
        Link,
        Button,
        ClientForm,
    },
    data() {
        return {
            clientsIndex,
        };
    },
};
</script>

