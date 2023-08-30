<div class="min-h-screen px-6">

    <div class="">
        <div class="w-1/2 mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Matricule</label>
            <input type="text" id="email" wire:model='matricule'
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                placeholder="matricule" required>
        </div>


        <button wire:click="valider()"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Envoyer</button>
    </div>


    <div>

        @empty(!$notesWithPivot)

        <div class="p-4 mt-8 bg-white rounded-md shadow-md dark:bg-gray-800">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th align="start" class="px-4 py-2">Matière</th>
                        <th align="start" class="px-4 py-2">Note</th>
                        <th align="start" class="px-4 py-2">Total</th>
                    </tr>
                </thead>

                <tbody>


                    @php
                    $totalGeneral = 0; // Initialiser le total général
                    $totalObtenu = 0; // Initialiser le total obtenu par l'élève
                    @endphp

                    @forelse ($notesWithPivot as $key => $value)
                    <tr class="border-b border-gray-300 dark:bg-gray-600">
                        <td class="px-4 py-2">{{ $value['matiere'] }}</td>
                        <td class="px-4 py-2">{{ $value['notes'] }}</td>
                        <td class="px-4 py-2">{{ $value['pivotNote'] }}</td>
                    </tr>
                    @php
                    $totalGeneral += $value['pivotNote']; // Ajouter la note pivot au total général

                    if ($value['notes'] !== 'Vide') {
                    $totalObtenu += $value['notes']; // Ajouter la note obtenue par l'élève au total obtenu
                    }
                    @endphp
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center">Aucune note disponible</td>
                    </tr>
                    @endforelse


                    @if(count($notesWithPivot) > 0)
                    <tr class="bg-gray-300 dark:bg-gray-700">
                        <td class="px-4 py-2 font-bold">Total général</td>
                        <td class="px-4 py-2 font-bold">{{ $totalObtenu }}</td>
                        <td class="px-4 py-2 font-bold">{{ $totalGeneral }}</td>
                    </tr>

                    <tr class="bg-gray-300 dark:bg-gray-700">
                        <td class="px-4 py-2 font-bold">Pourcentage final</td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2 font-bold">
                            @php
                            $pourcentageFinal = ($totalObtenu / $totalGeneral) * 100;
                            echo number_format($pourcentageFinal, 2) . '%';
                            @endphp
                        </td>
                    </tr>

                    @endif
                </tbody>

            </table>
        </div>

        @endempty
    </div>


</div>
