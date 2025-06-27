<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard - Sistema de Nómina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-bold mb-6 text-center">Bienvenido al Sistema de Nómina</h3>
                    <p class="mb-8 text-center text-lg text-gray-700 dark:text-gray-300">
                        Selecciona una de las opciones para comenzar:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 overflow-visible">
                        <!-- BLOQUE DE GESTION DE EMPLEADOS -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="block w-full bg-blue-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-users text-3xl mb-2"></i>
                                <span class="block text-lg font-semibold">Gestión de Empleados</span>
                            </button>

                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 text-left">
                                <a href="{{ route('empleados.create') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">➕ Agregar Empleado</a>
                                 <a href="{{ route('empleados.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">📄 Reporte de Empleados</a>
                                <a href="{{ route('historial.cargos') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">📄 Historial de Cargos</a>
                            </div>
                        </div>
                        <!-- BLOQUE DE GESTION DE USUARIOS -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="block w-full bg-yellow-500 text-white text-center py-6 rounded-lg shadow-md hover:bg-yellow-600 transition duration-300">
                                <i class="fas fa-user text-3xl mb-2"></i>
                                <span class="block text-lg font-semibold">Gestión de Usuarios</span>
                            </button>

                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 text-left">
                                <a href="{{ route('usuarios.create') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">➕ Agregar Usuario</a>

                                <a href="{{ route('usuarios.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">📋 Lista de Usuarios</a>
                            </div>
                        </div>
                        <!-- BLOQUE DE GESTION DE LIQUIDACIONES -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="block w-full bg-green-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                                <i class="fas fa-file-invoice-dollar text-3xl mb-2"></i>
                                <span class="block text-lg font-semibold">Gestión de Liquidaciones</span>
                            </button>

                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 text-left">
                                <a href="{{ route('liquidaciones.individual') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Liquidación Individual</a>
                                <a href="{{ route('liquidaciones.total') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Liquidación Total</a>
                                <a href="{{ route('liquidaciones.personalizado') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Liquidación Personalizada</a>
                                <a href="{{ route('reporte.nomina') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Reporte General de Nóminas</a>
                                <a href="{{ route('recibo.pago.lista') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Reporte de pago</a>
                            </div>
                        </div>
                        <!-- BLOQUE DE DESCUENTOS -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="block w-full bg-red-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-red-700 transition duration-300">
                                <i class="fas fa-chart-bar text-3xl mb-2"></i>
                                <span class="block text-lg font-semibold">Descuentos</span>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 text-left">
                                <div class="border-t border-gray-200 my-2"></div>
                                <a href="{{ route('ausencias.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded"> Descuentos por Ausencias</a>
                                <a href="{{ route('prestamos.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded"> Descuentos por Préstamos</a>
                                <a href="{{ route('embargos.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded"> Embargos Judiciales</a>
                                <a href="{{ route('retenciones.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded"> Retenciones Sindicales</a>
                                <a href="{{ route('conceptos.index') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded"> Conceptos Salariales</a>
                            </div>
                        </div>

                        <!-- BLOQUE DE REPORTE DE EMPLEADOS -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="block w-full bg-purple-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-purple-700 transition duration-300">
                                <i class="fas fa-users text-3xl mb-2"></i>
                                <span class="block text-lg font-semibold">Reporte de Empleados</span>
                            </button>

                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 text-left">
                                <a href="{{ route('reporte.extracto') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">➕ Extracto Personal</a>
                                <a href="{{ route('reporte.embargos') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">➕ Embargo Personal</a>

                                <a href="{{ route('reporte.datos_personales') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">📄 Datos Personales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>