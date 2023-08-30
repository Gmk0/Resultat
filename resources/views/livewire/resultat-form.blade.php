<div class="flex flex-col min-h-screen gap-2">


    <div class="mb-8">
        {{ $this->classeForm
        }}
    </div>

    <form wire:submit.prevent='newNote' class="flex flex-col gap-4 mb-8">
        {{ $this->addResult
        }}

        <div>
            <x-filament::button type="submit">
                Nouvelle note
            </x-filament::button>
        </div>








    </form>


    <div class="p-4 mt-16 bg-white rounded-md shadow-md dark:bg-gray-800">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th align="start" class="px-4 py-2">Matière</th>
                    <th align="start" class="px-4 py-2">Note</th>
                    <th align="start" class="px-4 py-2">Total</th>
                </tr>
            </thead>
            @empty(!$notesWithPivot)
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
            @endempty
        </table>
    </div>



    <x-filament-actions::modals />
</div>
