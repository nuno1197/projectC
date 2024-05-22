<template>
    <div class="mt-6">
        <div v-for="(drill, index) in drills" :key="index" class="mb-6">
            <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-400 relative">
                <div class="col-span-full lg:col-span-1">
                    <p class="font-medium">Drill {{ index + 1 }}</p>
                </div>
                <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'drill_name_' + index" class="text-sm">Drill Name</label>
                        <input :id="'drill_name_' + index" v-model="drill.name" type="text" placeholder="Drill Name" name="drill_name[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'drill_comment_' + index" class="text-sm">Comment</label>
                        <input :id="'drill_comment_' + index" v-model="drill.comment" type="text" placeholder="Comment" name="drill_comment[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                    </div>
                </div>
                <button type="button" @click="removeDrill(index)" class="absolute top-2 right-2 rounded-md bg-red-500 text-white px-3 py-1 hover:bg-red-700">Remove</button>
            </fieldset>
        </div>
        <div class="flex justify-center mt-4">
            <button type="button" @click="addDrill" class="rounded-md bg-gray-600 text-white py-6 w-full lg:w-3/4 hover:bg-gray-800 ">+</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            drills: []
        };
    },
    methods: {
        addDrill() {
            this.drills.push({ name: '', comment: '' });
        },
        removeDrill(index) {
            this.drills.splice(index, 1);
        }
    }
}
</script>

<style scoped>
.rounded-full {
    border-radius: 50%;
}
.mb-6 {
    margin-bottom: 1.5rem;
}
</style>
