<template>
    <MusicLayout>
        <template #title>
            Comptes Clients
        </template>

        <template #actions>
            <Link :href="clientsCreate().url">
                <Button>
                    <Plus class="size-4 mr-2" />
                    Ajouter un client
                </Button>
            </Link>
        </template>

        <template #content>
            <div v-if="!clients || clients.length === 0" class="flex flex-col items-center justify-center py-16">
                <div class="text-center space-y-4 max-w-md">
                    <div class="text-6xl">👥</div>
                    <h3 class="text-xl font-semibold">Aucun client</h3>
                    <p class="text-muted-foreground">
                        Commencez par ajouter votre premier compte client.
                    </p>
                    <Link :href="clientsCreate().url">
                        <Button>
                            <Plus class="size-4 mr-2" />
                            Ajouter un client
                        </Button>
                    </Link>
                </div>
            </div>

            <div v-else>
                <Card>
                    <CardContent class="p-0">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                            Email
                                        </th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                            Nom
                                        </th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                            Prénom
                                        </th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                            Société
                                        </th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                            Ville
                                        </th>
                                        <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="client in clients"
                                        :key="client.id"
                                        class="border-b transition-colors hover:bg-muted/50"
                                    >
                                        <td class="p-4 align-middle">
                                            {{ client.email }}
                                        </td>
                                        <td class="p-4 align-middle">
                                            {{ client.last_name }}
                                        </td>
                                        <td class="p-4 align-middle">
                                            {{ client.first_name }}
                                        </td>
                                        <td class="p-4 align-middle">
                                            {{ client.company || '-' }}
                                        </td>
                                        <td class="p-4 align-middle">
                                            {{ client.city || '-' }}
                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <Link
                                                    :href="clientsEdit({ client: client.id }).url"
                                                >
                                                    <Button variant="outline" size="sm">
                                                        <Pencil class="size-4" />
                                                    </Button>
                                                </Link>
                                                <Link
                                                    :href="clientsDestroy({ client: client.id }).url"
                                                    method="delete"
                                                    as="button"
                                                    preserve-scroll
                                                >
                                                    <Button variant="destructive" size="sm">
                                                        <Trash2 class="size-4" />
                                                    </Button>
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </template>
    </MusicLayout>
</template>

<script>
import MusicLayout from '@/layouts/MusicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import { index as clientsIndex, create as clientsCreate, edit as clientsEdit, destroy as clientsDestroy } from '@/routes/clients';

export default {
    name: 'ClientsIndex',
    components: {
        MusicLayout,
        Link,
        Card,
        CardContent,
        Button,
        Plus,
        Pencil,
        Trash2,
    },
    props: {
        clients: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            clientsIndex,
            clientsCreate,
            clientsEdit,
            clientsDestroy,
        };
    },
};
</script>

