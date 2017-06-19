# language: es
Característica: ABM Organismos

  Escenario: Mostrar Pantalla
    Dado estoy en login
    Cuando relleno usuario con 1
    Y relleno password con 1
    Y presiono send
    Y voy a asociados
    Entonces la URL debe seguir el patron "asociados
