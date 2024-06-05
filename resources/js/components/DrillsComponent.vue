<template xmlns="http://www.w3.org/1999/html">
    <div class="mt-6">
        <div v-for="(drill, index) in drills" :key="index" class="mb-6">
            <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md border-2 border-gray-500 shadow-sm bg-white text-rich_black dark:bg-rich_black dark:text-white dark:border-orange_fruit relative ">
                <div class="col-span-full lg:col-span-1">
                    <p class="font-medium">Drill {{ index + 1 }}</p>
                </div>
                <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'drill_name_' + index" class="text-sm">Drill Name *</label>
                        <input :id="'drill_name_' + index" v-model="drill.name" type="text" placeholder="Drill Name" name="drill_name[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'objective' + index" class="text-sm">Drill Objective *</label>
                        <textarea :id="'objective_' + index" v-model="drill.objective" placeholder="Objectives of this drill? What you want to achieve?" name="objective[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit"></textarea>
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'rules' + index" class="text-sm">Drill Rules *</label>
                        <textarea :id="'rules_' + index" v-model="drill.rules" placeholder="rules" name="rules[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit"></textarea>
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'public' + index" class="text-sm">Do you want this drill to be public? (if yes click in the check box) *</label>
                        <input :id="'public_' + index" v-model="drill.public" type="checkbox" name="public[]" class=" ml-2 rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'number_players' + index" class="text-sm">Minimum Players for this drill</label>
                        <input :id="'number_players_' + index" v-model="drill.number_players" type="number" placeholder="10" name="number_players[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'material' + index" class="text-sm">Material for this Drill</label>
                        <textarea :id="'material_' + index" v-model="drill.material" placeholder="rules" name="material[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit"></textarea>
                    </div>
                    <div class="col-span-full sm:col-span-3">
                        <label :for="'age_squad' + index" class="text-sm">Appropriate age group</label>
                        <input :id="'age_squad_' + index" v-model="drill.age_squad" type="text" placeholder="Under 13,14" name="age_squad[]" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-rich_black focus:dark:ring-orange-800 dark:border-orange_fruit">
                    </div>
                </div>
                <button type="button" @click="removeDrill(index)" class="absolute top-2 right-2 rounded-md bg-red-500 text-white px-3 py-1 hover:bg-red-700">Remove</button>
            </fieldset>
        </div>
        <div class="flex justify-center mt-4">
            <button type="button" @click="addDrill" class="rounded-md bg-gray-600 text-white py-6 w-full lg:w-3/4 hover:bg-gray-800">+</button>
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
            this.drills.push({ name: '', objective: '', rules: '', public: false, number_players:'', material:'', age_squad:'', });
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
