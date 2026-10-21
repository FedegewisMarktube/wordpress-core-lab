# WordPress Core Lab: instrucciones de desarrollo

## Contexto y alcance

Laboratorio en `/home/fedeg/Trabajo/wordpress-core-lab`, sobre Ubuntu/WSL con Docker Compose, PHP 8.3 y MySQL 8.0. El plugin propio está en `plugins/wordpress-core-lab/`.

Trabajar incrementalmente: completar solo la subtarea solicitada y esperar instrucciones para la siguiente. No reinstalar WordPress ni reconfigurar Docker. No crear archivos vacíos o dependencias innecesarias.

## Flujo obligatorio

1. Leer las instrucciones aplicables y revisar Git antes de modificar archivos.
2. Explicar requisitos, APIs nativas, archivos a modificar, decisiones y riesgos antes de implementar.
3. Implementar dentro del plugin con responsabilidades separadas, validaciones y documentación.
4. Revisar el diff y ejecutar las comprobaciones posibles.
5. Informar cambios, pruebas realmente ejecutadas, pasos manuales y pendientes. No afirmar que pasó una prueba que no se ejecutó.

## Arquitectura y convenciones

- Nunca modificar WordPress Core ni plugins de terceros.
- Priorizar APIs nativas, evitar duplicación y seguir los estándares de WordPress.
- Mantener compatibilidad con PHP 8.3.
- Usar `wcl_` como prefijo de funciones, opciones, hooks, capacidades, transients e identificadores propios; dominio de traducción: `wordpress-core-lab`.
- Proteger archivos PHP ejecutables con `ABSPATH`.
- Mantener la entrada del plugin dedicada a metadatos, carga explícita de módulos y hooks de ciclo de vida.
- Registrar callbacks en hooks adecuados; evitar trabajo costoso al cargar archivos.
- Preferir callbacks con nombre y prefijo cuando deban retirarse o probarse.
- Preparar textos de interfaz para traducción.

### Organización propuesta, a crear según necesidad

```text
plugins/wordpress-core-lab/
  wordpress-core-lab.php       # Entrada y carga de módulos.
  includes/
    post-types.php            # Custom Post Types.
    taxonomies.php            # Taxonomías.
    capabilities.php          # Roles, capacidades y ciclo de vida.
    settings.php              # Registro y sanitización de opciones.
    rest-api.php              # Rutas, permisos y contratos REST.
    transients.php            # Caché, expiración e invalidación.
    cron.php                  # Eventos y callbacks programados.
  admin/
    settings-page.php         # Registro y renderizado de la página administrativa.
docs/
  decisiones-tecnicas.md
  errores-encontrados.md
  conclusiones.md
tests/                        # Pruebas justificadas por funcionalidad.
```

Crear cada archivo cuando tenga contenido útil. Preferir módulos funcionales pequeños; introducir clases si el estado o la complejidad lo justifican. Mantener consultas paginadas en el módulo consumidor y extraerlas si existe reutilización real.

## Seguridad

- Validar tipos, rangos y valores permitidos; sanitizar según el significado del dato.
- Aplicar `wp_unslash()` donde corresponda a entradas procesadas por WordPress.
- Escapar en el punto de salida según contexto: `esc_html()`, `esc_attr()`, `esc_url()`, etc.
- Verificar capacidades mediante `current_user_can()` en acciones protegidas.
- Usar y verificar nonces cuando corresponda; no sustituyen autorización.
- Definir `permission_callback` en toda ruta REST; permitir acceso público solo cuando sea un requisito explícito.
- Preferir APIs de consulta de WordPress; para SQL propio con valores variables usar `$wpdb->prepare()` y validar identificadores dinámicos.
- No exponer ni versionar credenciales o datos sensibles. No imprimir `.env`, logs sensibles ni configuración resuelta con contraseñas.

## Rendimiento y recursos

- Evitar consultas redundantes y procesos costosos en cada solicitud.
- Paginar y limitar listados; no calcular totales innecesarios.
- Usar Transients API cuando aporte valor, con expiración e invalidación; contemplar desaparición anticipada de caché.
- Evitar eventos WP-Cron duplicados y desprogramarlos en la desactivación.
- Limpiar recursos temporales cuando corresponda y definir qué datos persisten. No borrar contenido del usuario sin autorización.
- Aplicar cambios de roles y reglas de reescritura en el ciclo de vida adecuado, no en cada solicitud.

## Git

- Mantener `main` estable y desarrollar cada funcionalidad en una rama `feature/`.
- Revisar el estado antes de editar y preservar cambios del usuario.
- No realizar commits ni pushes sin autorización explícita.
- No ejecutar comandos destructivos de Git.
- Preferir Git dentro de WSL; no cambiar automáticamente la configuración global ante problemas de propiedad desde Windows.

## Docker

- Mantener el entorno reproducible y conservar las credenciales existentes.
- No eliminar contenedores, volúmenes ni bases de datos sin autorización.
- Nunca ejecutar `docker compose down -v`.
- No reinstalar WordPress ni modificar Compose fuera del alcance solicitado.
- Validar con `docker compose config --quiet` para evitar imprimir secretos.
- Preferir PHP dentro del servicio `wordpress` para verificar con el runtime real.

## Documentación por funcionalidad

Documentar: objetivo; API nativa; motivo de elección; archivos modificados; funcionamiento; validaciones y seguridad; pasos reproducibles desde WordPress; errores encontrados y soluciones; riesgos y limitaciones; conclusiones técnicas.

Indicar si no se detectaron errores. Usar `docs/` según el contenido real, enlazar desde README cuando corresponda y evitar duplicación o documentos vacíos.

## Verificación

- Ejecutar `php -l` sobre PHP nuevo o modificado, preferentemente dentro del contenedor.
- Comprobar que WordPress responda y verificar la funcionalidad afectada.
- Ejecutar las pruebas existentes pertinentes y proponer automatización cuando aporte valor para lógica, permisos, validaciones o ciclo de vida.
- No añadir pruebas triviales ni instalar herramientas solo para completar una lista.
- Informar limitaciones de herramientas o acceso y explicar verificaciones manuales pendientes; una respuesta HTTP no equivale a una prueba funcional completa.
- No realizar comprobaciones que destruyan datos locales.
