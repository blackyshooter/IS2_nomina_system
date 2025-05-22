<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight dark:text-gray-200">Editar Empleado</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded dark:bg-red-900 dark:text-red-300">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('empleados.update', $empleado->id_empleado) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Íconos SVG para usar en labels --}}
            @php
            $icons = [
                'nombre' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A5 5 0 1117.803 5.121 5 5 0 015.12 17.804zM9 19h6"/></svg>',
                'apellido' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A5 5 0 1117.803 5.121 5 5 0 015.12 17.804zM9 19h6"/></svg>',
                'fecha' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
                'cedula' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>',
                'correo' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 12l-4 4m0 0l-4-4m4 4V8"/></svg>',
                'telefono' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" d="M3 10l7 7m0 0l7-7m-7 7V3"/></svg>',
                'salario' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8c-2 0-3 1-3 3s1 3 3 3"/></svg>',
                'hijo' => '<svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="7" r="4"/><path d="M5.5 21h13"/></svg>',
            ];
            @endphp

            {{-- Datos básicos empleado --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['nombre'] !!} Nombre
                    </label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $empleado->nombre) }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" required>
                </div>

                <div>
                    <label for="apellido" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['apellido'] !!} Apellido
                    </label>
                    <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $empleado->apellido) }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" required>
                </div>

                <div>
                    <label for="fecha_ingreso" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['fecha'] !!} Fecha de Ingreso
                    </label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso', $empleado->fecha_ingreso ? $empleado->fecha_ingreso->format('Y-m-d') : '') }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" required>
                </div>

                <div>
                    <label for="cedula" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['cedula'] !!} Cédula
                    </label>
                    <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $empleado->cedula) }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" required>
                </div>

                <div>
                    <label for="correo" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['correo'] !!} Correo
                    </label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo', $empleado->correo) }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                </div>

                <div>
                    <label for="telefono" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['telefono'] !!} Teléfono
                    </label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                </div>

                <div>
                    <label for="fecha_nacimiento" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['fecha'] !!} Fecha de Nacimiento
                    </label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento ? $empleado->fecha_nacimiento->format('Y-m-d') : '') }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" required>
                </div>

                <div>
                    <label for="salario_base" class="block font-semibold text-gray-700 dark:text-gray-300">
                        {!! $icons['salario'] !!} Salario Base
                    </label>
                    <input type="number" step="0.01" name="salario_base" id="salario_base" value="{{ old('salario_base', $empleado->salario_base) }}" class="mt-1 border border-gray-300 rounded p-2 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" required>
                </div>
            </div>

            {{-- Sección Hijos --}}
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-400">Hijos</h3>

                <div id="hijos-container" class="space-y-4">
                    @foreach(old('hijos', $empleado->hijos ?? []) as $index => $hijo)
                        <div class="mb-4 border border-gray-300 dark:border-gray-600 p-4 rounded relative bg-gray-50 dark:bg-gray-700 hijo-item">
                            <input type="hidden" name="hijos[{{ $index }}][id_hijo]" value="{{ $hijo['id_hijo'] ?? $hijo->id_hijo ?? '' }}">

                            <label class="block font-semibold text-gray-700 dark:text-gray-300">
                                {!! $icons['nombre'] !!} Nombre
                            </label>
                            <input type="text" name="hijos[{{ $index }}][nombre]" value="{{ old("hijos.$index.nombre", $hijo['nombre'] ?? $hijo->nombre) }}" class="border border-gray-300 rounded w-full p-2 mt-1 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" required>

                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mt-4">
                                {!! $icons['apellido'] !!} Apellido
                            </label>
                            <input type="text" name="hijos[{{ $index }}][apellido]" value="{{ old("hijos.$index.apellido", $hijo['apellido'] ?? $hijo->apellido) }}" class="border border-gray-300 rounded w-full p-2 mt-1 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" required>

                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mt-4">
                                {!! $icons['fecha'] !!} Fecha de Nacimiento
                            </label>
                            <input type="date" name="hijos[{{ $index }}][fecha_nacimiento]" value="{{ old("hijos.$index.fecha_nacimiento", isset($hijo['fecha_nacimiento']) ? \Carbon\Carbon::parse($hijo['fecha_nacimiento'])->format('Y-m-d') : (isset($hijo->fecha_nacimiento) ? $hijo->fecha_nacimiento->format('Y-m-d') : '')) }}" class="border border-gray-300 rounded w-full p-2 mt-1 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" required>

                            <button type="button" class="absolute top-2 right-2 text-red-600 hover:text-red-800 font-bold btn-remove-hijo" title="Eliminar hijo">&times;</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="btn-add-hijo" class="mt-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">Agregar hijo</button>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded font-semibold">Guardar Cambios</button>
            </div>
        </form>
    </div>

    {{-- Plantilla oculta para nuevo hijo --}}
    <template id="template-hijo">
        <div class="mb-4 border border-gray-300 dark:border-gray-600 p-4 rounded relative bg-gray-50 dark:bg-gray-700 hijo-item">
            <input type="hidden" name="hijos[__INDEX__][id_hijo]" value="">

            <label class="block font-semibold text-gray-700 dark:text-gray-300">{!! $icons['nombre'] !!} Nombre</label>
            <input type="text" name="hijos[__INDEX__][nombre]" class="border border-gray-300 rounded w-full p-2 mt-1 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" required>

            <label class="block font-semibold text-gray-700 dark:text-gray-300 mt-4">{!! $icons['apellido'] !!} Apellido</label>
            <input type="text" name="hijos[__INDEX__][apellido]" class="border border-gray-300 rounded w-full p-2 mt-1 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" required>

            <label class="block font-semibold text-gray-700 dark:text-gray-300 mt-4">{!! $icons['fecha'] !!} Fecha de Nacimiento</label>
            <input type="date" name="hijos[__INDEX__][fecha_nacimiento]" class="border border-gray-300 rounded w-full p-2 mt-1 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600" required>

            <button type="button" class="absolute top-2 right-2 text-red-600 hover:text-red-800 font-bold btn-remove-hijo" title="Eliminar hijo">&times;</button>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnAddHijo = document.getElementById('btn-add-hijo');
            const container = document.getElementById('hijos-container');
            const template = document.getElementById('template-hijo').innerHTML;

            // Contador para índices de hijos (empezar con la cantidad actual para evitar colisiones)
            let hijoIndex = {{ count(old('hijos', $empleado->hijos ?? [])) }};

            btnAddHijo.addEventListener('click', () => {
                const newHijoHtml = template.replace(/__INDEX__/g, hijoIndex);
                container.insertAdjacentHTML('beforeend', newHijoHtml);
                hijoIndex++;
            });

            // Delegación de evento para eliminar hijo (tanto para existentes como nuevos)
            container.addEventListener('click', (e) => {
                if (e.target.classList.contains('btn-remove-hijo')) {
                    const hijoItem = e.target.closest('.hijo-item');
                    if (hijoItem) {
                        hijoItem.remove();
                    }
                }
            });
        });
    </script>
</x-app-layout>
