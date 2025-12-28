<template>
    <MusicLayout>
        <template #title>
            Modifier un client
        </template>

        <template #actions>
            <Link :href="clientsIndex().url">
                <Button variant="outline">
                    Retour
                </Button>
            </Link>
        </template>

        <template #content>
            <ClientForm :client="client" />
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
    name: 'ClientsEdit',
    components: {
        MusicLayout,
        Link,
        Button,
        ClientForm,
    },
    props: {
        client: Object,
    },
    data() {
        return {
            clientsIndex,
        };
    },
};
</script>

