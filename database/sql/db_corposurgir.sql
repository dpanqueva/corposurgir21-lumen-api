-- bd corposurgir21
-- u corposurgir21
-- pass C0rposurg1R21@2023
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2023 a las 14:57:03
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_corposurgir`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alianza`
--

CREATE TABLE `alianza` (
  `alianza_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  `ruta_imagen` varchar(100) NOT NULL,
  `snactivo` char(1) DEFAULT 'S',
  `pagina_web` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `barrio` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alianza`
--

INSERT INTO `alianza` (`alianza_id`, `nombre`, `descripcion`, `ruta_imagen`, `snactivo`, `pagina_web`, `direccion`, `barrio`) VALUES
(1, 'conoser', 'Inclusión social por medio de la cocina: pedagogía y prácticas en servicio y gastronomía.', 'assets/img/clients/conoser.png', 'S', NULL, NULL, NULL),
(2, 'dental-studio', 'Odontología integral, general y especializada. Allí encontraras tratamientos decalidad realizados por profesionales.', 'assets/img/clients/dentalStudio.png', 'S', NULL, NULL, NULL),
(3, 'vision-plus', 'Estamos con el mejor servicio de asesoría y un gran equipo profesional de Optometría.', 'assets/img/clients/visionPlus.png', 'S', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alianza_caracteristica`
--

CREATE TABLE `alianza_caracteristica` (
  `alianza_caracteristica_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `codigo_nombre` varchar(45) NOT NULL,
  `nombre_caracteristica` varchar(45) NOT NULL,
  `alianza_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alianza_caracteristica`
--

INSERT INTO `alianza_caracteristica` (`alianza_caracteristica_id`, `descripcion`, `codigo_nombre`, `nombre_caracteristica`, `alianza_id`) VALUES
(1, 'Cocina nacional.', 'conoser', 'Cocina nacional', 1),
(2, 'Cocina internacional.', 'conoser', 'Cocina internacional', 1),
(3, 'Coctelería.', 'conoser', 'Coctelería', 1),
(4, 'Repostería.', 'conoser', 'Repostería', 1),
(5, 'Postres.', 'conoser', 'Postres', 1),
(6, 'Barismo.', 'conoser', 'Barismo', 1),
(7, 'Barbacoas.', 'conoser', 'Barbacoas', 1),
(8, 'Prótesis fija y removible.', 'dental-studio', 'Prótesis', 2),
(9, 'Profilaxis y detartraje.', 'dental-studio', 'Profilaxis', 2),
(10, 'Ortodoncia.', 'dental-studio', 'Ortodoncia', 2),
(11, 'Blanqueamiento dental.', 'dental-studio', 'Blanqueamiento dental', 2),
(12, 'Diseño de sonrisa.', 'dental-studio', 'Diseño de sonrisa', 2),
(13, 'Exodoncia.', 'dental-studio', 'Exodoncia', 2),
(14, 'Resinas.', 'dental-studio', 'Resinas', 2),
(15, 'Endodoncia.', 'dental-studio', 'Endodoncia', 2),
(16, 'Flúor.', 'dental-studio', 'Flúor', 2),
(17, 'Sellantes.', 'dental-studio', 'Sellantes', 2),
(18, 'Consulta de optometría computadorizada y manual.', 'vision-plus', 'Optometría', 3),
(19, 'Certificados visuales, laborales, escolares y para licencia de conducción.', 'vision-plus', 'Certificados', 3),
(20, 'Visiometrias.', 'vision-plus', 'Visiometrias', 3),
(21, 'Test de colores  ishihara y farnsworth D-15.', 'vision-plus', 'Test', 3),
(22, 'Urgencias visuales  lavados y extracción de esquirlas.', 'vision-plus', 'Urgencias', 3),
(23, 'Adaptación de lentes de contacto blandos y gases permeables.', 'vision-plus', 'Adaptación', 3),
(24, 'Venta soluciones para lentes de contacto y lubricantes oculares.', 'vision-plus', 'Lentes de Contacto', 3),
(25, 'Toda clase de reparaciones y soldaduras para las monturas.', 'vision-plus', 'Reparaciones', 3),
(26, 'Venta de accesorios para gafas.', 'vision-plus', 'Accesorios', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `snactivo` char(1) NOT NULL DEFAULT 'S',
  `logo` varchar(45) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `nombre`, `codigo`, `snactivo`, `logo`, `descripcion`) VALUES
(1, 'Salud', 'salud', 'S', 'bi bi-arrow-through-heart', 'La salud ​ es un estado de bienestar o de equilibrio que puede ser visto a nivel subjetivo o a nivel objetivo.'),
(2, 'Vivienda', 'vivienda', 'S', 'bi bi-house-heart', 'CORPOSURGIR21 implementa programas integrales de vivienda social digna, servicios complementarios y generación de empleo, diseñando estrategias financieras con base en el análisis socioeconómico personalizado y establece los mecanismos de ejecución y control de los programas, dando acceso efectivo a la adquisición de vivienda y servicios a todos los sectores sociales discriminados y de escasos recursos.'),
(3, 'Educación', 'educacion', 'S', 'bi bi-book', 'La educación es el proceso de facilitar el aprendizaje o la adquisición de conocimientos, así como habilidades, valores, creencias y hábitos.'),
(4, 'Víctimas de violencia', 'violencia', 'S', 'bi bi-bookmark-heart', 'Las instituciones prestadoras de servicios de salud deben contar con personal capacitado en atención integral en salud a víctimas de violencia sexual para dar cumplimiento a la resolución 3100 de 2019 del Ministerio de Salud y Protección Social.'),
(5, 'Recreación', 'recreacion', 'S', 'bi bi-bicycle', 'Son aquellas actividades que realizamos, aprovechando el tiempo libre en el esparcimiento físico y mental.'),
(6, 'Procesos legales', 'legal', 'S', 'bi bi-bag-check', 'Los actos jurídicos son del Estado, de las partes interesadas y de los terceros ajenos a la relación sustancial.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_caracteristica`
--

CREATE TABLE `categoria_caracteristica` (
  `detalle_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `codigo_nombre` varchar(45) NOT NULL,
  `nombre_caracteristica` varchar(45) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria_caracteristica`
--

INSERT INTO `categoria_caracteristica` (`detalle_id`, `descripcion`, `codigo_nombre`, `nombre_caracteristica`, `categoria_id`) VALUES
(1, 'Medicina general', 'salud', 'Medicina general', 1),
(2, 'Ortopedia', 'salud', 'Ortopedia', 1),
(3, 'Cirugía plástica', 'salud', 'Cirugía plástica', 1),
(4, 'Cirugía mexilofacial', 'salud', 'Cirugía mexilofacial', 1),
(5, 'Neurología', 'salud', 'Neurología', 1),
(6, 'Psicología', 'salud', 'Psicología', 1),
(7, 'Otorrino', 'salud', 'Otorrino', 1),
(8, 'Oftalmología', 'salud', 'Oftalmología', 1),
(9, 'A fin de planificar el gasto familiar y fomentar la disciplina del ahorro.', 'vivienda', 'Análisis socioeconómicos personalizados', 2),
(10, 'A fin de planificar el gasto familiar y fomentar la disciplina del ahorro.', 'vivienda', 'Análisis socioeconómicos personalizados', 2),
(11, 'Definiendo previamente la verdadera capacidad de endeudamiento del grupo familiar y de su estabilidad financiera con miras a créditos hipotecarios a mediano plazo y proyectar así el pago de la vivienda.', 'vivienda', 'Diagnosticar', 2),
(12, 'De los verdaderos requerimientos espaciales de su vivienda dentro de programas de desarrollo progresivo.', 'vivienda', 'Educación familiar', 2),
(13, 'A las familias afiliadas al programa, para convertirse en propietarios de vivienda DIGNA a través de los distintos subsidios que el Estado ofrece a dichos beneficiarios.', 'vivienda', 'Brindar asesoramiento', 2),
(14, 'D.D.H.H', 'educacion', 'D.D.H.H', 3),
(15, 'Aprende a crear empresa, tips y pasos para lograrlo.', 'educacion', 'Creación de empresas', 3),
(16, 'Aprende a formular tus propios proyectos.', 'educacion', 'Formulación de proyectos', 3),
(17, 'Otro idioma te abre caminos y oportunidades únicas.', 'educacion', 'Brindar asesoramiento', 3),
(18, 'Programa de 40 horas.', 'violencia', 'Protocolo de atención clínca', 4),
(19, 'Protocolo de atención clínca.', 'violencia', 'Tipos de violencia', 4),
(20, 'Tipos de violencia.', 'violencia', 'Tipos de violencia', 4),
(21, 'Atención médica y médico legal.', 'violencia', 'Proceso', 4),
(22, 'Detallado del área genital.', 'violencia', 'Examen', 4),
(23, 'Preventivas del abuso sexual.', 'violencia', 'Estrategias', 4),
(24, 'Indicadores de violencia sexual.', 'violencia', 'Indicadores de violencia sexual', 4),
(25, 'Biológicas, embalaje y cadena de custodia.', 'violencia', 'Evidencia', 4),
(26, 'Profilaxis de embarazo e infecciones de transmisión sexual.', 'violencia', 'Contagios', 4),
(27, 'Entrevista forense.', 'violencia', 'Entrevista forense', 4),
(28, 'Sindrome de acomodación.', 'violencia', 'Sindrome de acomodación', 4),
(29, 'Consecuencias mentales en abuso sexual.', 'violencia', 'Consecuencias', 4),
(30, 'Uso de sistema SICLICO del instituo nacional de medicina legal.', 'violencia', 'Radicación de casos', 4),
(31, 'Ruta de atención a victimas de casos de violencia sexual.', 'violencia', 'Rutas', 4),
(32, 'Atención a víctimas de violencia sexual.', 'violencia', 'Marco jurídico', 4),
(33, 'Sistema médico legal.', 'violencia', 'Concepto jurídico', 4),
(34, 'Tipos de delitos de violencia sexual.', 'violencia', 'Tipología', 4),
(35, 'Casos clínicos.', 'violencia', 'Casos clínicos', 4),
(36, 'Fiestas infantiles, animaciones, juegos y lúdica.', 'recreacion', 'Fiestas', 5),
(37, 'Personal trainer.', 'recreacion', 'Actividad física', 5),
(38, 'Rumba, Zumba, Body combat, Fit combat, Pilates, Yoga, Trx, Entretenmiento funcional, Box.', 'recreacion', 'Clases grupales', 5),
(39, 'Fincas, parques de temática.', 'recreacion', 'Turismo', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactanos`
--

CREATE TABLE `contactanos` (
  `contacto_id` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `numero_contacto` varchar(10) NOT NULL,
  `tipo_contacto` varchar(20) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donacion`
--

CREATE TABLE `donacion` (
  `donacion_id` int(11) NOT NULL,
  `banco_entidad` varchar(50) NOT NULL,
  `tipo_cuenta` varchar(50) NOT NULL,
  `numero_cuenta` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_central`
--

CREATE TABLE `imagen_central` (
  `imagen_central_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ruta_imagen` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `snactivo` char(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_empresa`
--

CREATE TABLE `informacion_empresa` (
  `info_empresa_id` int(11) NOT NULL,
  `nombre_empresa` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad_pais` varchar(100) NOT NULL,
  `numero_fijo` varchar(45) NOT NULL,
  `numero_celular` varchar(45) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `informacion_empresa`
--

INSERT INTO `informacion_empresa` (`info_empresa_id`, `nombre_empresa`, `direccion`, `ciudad_pais`, `numero_fijo`, `numero_celular`, `correo`) VALUES
(1, 'Corposurgir21', 'Av calle 19 # 7-12', 'Bogotá, Colombia', '(601)7043540', '+57 315 5038280', 'Corposurgir21@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quienes_somos`
--

CREATE TABLE `quienes_somos` (
  `quienes_somos_id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `clase` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `quienes_somos`
--

INSERT INTO `quienes_somos` (`quienes_somos_id`, `titulo`, `descripcion`, `logo`, `clase`) VALUES
(1, 'Misión', 'Ayudamos a familias en general a través de estrategias y actividades que les permitan acceder fácilmente a sus derechos en educación, vivienda, salud, recreación, subsidios y empleo, representándolos ante el Estado como garantes para el logro de sus objetivos dentro del marco humanitario y ambiental del bien ser y el bien hacer.', 'bi bi-airplane-engines', 'azul-corporativo'),
(2, 'Visión', 'A 2026 estar posicionados como líderes sensibles y comprometidos con las problemáticas socioeconómicas de las familias colombianas, logrando su mejoramiento continuo de nivel y calidad de vida disponiendo para ello de todo un talento humano comprometido con las causas justas desde lo humano y ambiental.', 'bi bi-award-fill', 'verde-corporativo'),
(3, 'Compromiso', 'Prestar todo nuestro apoyo al ciudadano del común, al empresario generador de empleo, a la población vulnerable, a los gremios y al Estado; de tal forma que entre todos encontremos soluciones a los temas de seguridad social, manejo de nómina, vivienda, subsidios, salud, educación, turismo, conciliación, asesoría jurídica entre otros, con el compromiso de reconocer los derechos de cada uno actuando dentro del marco legal.', 'bi bi-bookmark-star-fill', 'gris-corporativo'),
(4, 'Recurso humano', 'Administradores de empresas con énfasis en trabajo social. Psicología organizacional, médicos generales, especialistas en salud; todos ellos prestos al manejo de temas de salud ocupacional, riesgos profesionales. Abogados expertos en servicio social y jurídico, dispuestos a asesorar antes que contratar. Contadores, economistas, ingenieros de sistemas, civiles, industriales, arquitectos y profesionales de áreas sociales quienes procuran servir antes que servirse. profesionales en el área fitness, deportiva y recreativa. Expertos en tránsito, transporte y seguridad vial.', 'bi bi-hand-thumbs-up-fill', 'azul-oscuro-corporativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales_empresa`
--

CREATE TABLE `redes_sociales_empresa` (
  `red_social_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `url_red_social` varchar(100) NOT NULL,
  `logo` varchar(45) NOT NULL,
  `info_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `redes_sociales_empresa`
--

INSERT INTO `redes_sociales_empresa` (`red_social_id`, `nombre`, `url_red_social`, `logo`, `info_empresa_id`) VALUES
(2, 'twitter', 'https://twitter.com/corposurgir21', 'bi bi-twitter', 1),
(3, 'facebook', 'https://www.facebook.com/corposurgir21', 'bi bi-facebook', 1),
(4, 'instagram', 'https://www.instagram.com/corposurgir21', 'bi bi-instagram', 1),
(5, 'google', 'https://www.google+.com/corposurgir21', 'bi bi-google', 1),
(6, 'linkedin', 'https://co.linkedin.com/corposurgir21', 'bi bi-linkedin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `correo_verificado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `clave` varchar(255) NOT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `apellido`, `correo`, `correo_verificado_en`, `clave`, `api_token`, `remember_token`) VALUES
(1, 'Jorge', 'Benítez', 'jorge.benitez@corposurgir21.org', '2023-02-24 14:49:45', '$2y$10$JkEhIKPe2CenUZXBkdoU.eO7BTE3ixOSiJjayIEGNrI52ohe.XoF6', NULL, NULL),
(2, 'Diego', 'Panqueva', 'daerb9011@gmail.com', '2023-03-04 00:15:26', '$2y$10$2X3XltqL.cs7jo6B0sJTC.gi7KqKezrebFdOwaX9T1L9Z85JxurTO', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alianza`
--
ALTER TABLE `alianza`
  ADD PRIMARY KEY (`alianza_id`);

--
-- Indices de la tabla `alianza_caracteristica`
--
ALTER TABLE `alianza_caracteristica`
  ADD PRIMARY KEY (`alianza_caracteristica_id`),
  ADD KEY `fk_alianza_caracteristica_alianza1_idx` (`alianza_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `categoria_caracteristica`
--
ALTER TABLE `categoria_caracteristica`
  ADD PRIMARY KEY (`detalle_id`),
  ADD KEY `fk_categoria_caracteristica_categoria1_idx` (`categoria_id`);

--
-- Indices de la tabla `contactanos`
--
ALTER TABLE `contactanos`
  ADD PRIMARY KEY (`contacto_id`);

--
-- Indices de la tabla `donacion`
--
ALTER TABLE `donacion`
  ADD PRIMARY KEY (`donacion_id`);

--
-- Indices de la tabla `imagen_central`
--
ALTER TABLE `imagen_central`
  ADD PRIMARY KEY (`imagen_central_id`);

--
-- Indices de la tabla `informacion_empresa`
--
ALTER TABLE `informacion_empresa`
  ADD PRIMARY KEY (`info_empresa_id`);

--
-- Indices de la tabla `quienes_somos`
--
ALTER TABLE `quienes_somos`
  ADD PRIMARY KEY (`quienes_somos_id`);

--
-- Indices de la tabla `redes_sociales_empresa`
--
ALTER TABLE `redes_sociales_empresa`
  ADD PRIMARY KEY (`red_social_id`),
  ADD KEY `fk_redes_sociales_empresa_informacion_empresa1_idx` (`info_empresa_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alianza`
--
ALTER TABLE `alianza`
  MODIFY `alianza_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `alianza_caracteristica`
--
ALTER TABLE `alianza_caracteristica`
  MODIFY `alianza_caracteristica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categoria_caracteristica`
--
ALTER TABLE `categoria_caracteristica`
  MODIFY `detalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `contactanos`
--
ALTER TABLE `contactanos`
  MODIFY `contacto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donacion`
--
ALTER TABLE `donacion`
  MODIFY `donacion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen_central`
--
ALTER TABLE `imagen_central`
  MODIFY `imagen_central_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informacion_empresa`
--
ALTER TABLE `informacion_empresa`
  MODIFY `info_empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `quienes_somos`
--
ALTER TABLE `quienes_somos`
  MODIFY `quienes_somos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `redes_sociales_empresa`
--
ALTER TABLE `redes_sociales_empresa`
  MODIFY `red_social_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alianza_caracteristica`
--
ALTER TABLE `alianza_caracteristica`
  ADD CONSTRAINT `fk_alianza_caracteristica_alianza1` FOREIGN KEY (`alianza_id`) REFERENCES `alianza` (`alianza_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `categoria_caracteristica`
--
ALTER TABLE `categoria_caracteristica`
  ADD CONSTRAINT `fk_categoria_caracteristica_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `redes_sociales_empresa`
--
ALTER TABLE `redes_sociales_empresa`
  ADD CONSTRAINT `fk_redes_sociales_empresa_informacion_empresa1` FOREIGN KEY (`info_empresa_id`) REFERENCES `informacion_empresa` (`info_empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
  
CREATE INDEX ix_alianza_nombre ON alianza(nombre);
CREATE INDEX ix_alianza_detalle ON alianza_caracteristica(alianza_id,codigo_nombre);
CREATE INDEX ix_alianza_detalle_codigo_nombre ON alianza_caracteristica(codigo_nombre);
CREATE INDEX ix_categoria_codigo ON categoria(codigo);
CREATE INDEX ix_usuario_correo ON usuarios(correo);
CREATE INDEX ix_usuario_token ON usuarios(api_token);
COMMIT;

--
-- Añadir nuevos campos a la tabla categoria y categoria_caracteristica
--
ALTER TABLE categoria
ADD COLUMN bln_cinta_noticia TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN fe_fin_cinta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE categoria_caracteristica
ADD COLUMN bln_cinta_noticia TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN fe_fin_cinta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
