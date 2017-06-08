INSERT INTO `#__osrs_extra_fields` (`id`, `group_id`, `field_type`, `field_name`, `field_label`, `field_description`, `ordering`, `required`, `show_description`, `options`, `default_value`, `size`, `maxlength`, `value_type`, `ncols`, `nrows`, `readonly`, `searchable`, `displaytitle`, `show_on_list`, `access`, `published`) VALUES
(86, 4, 'text', 'mls_id', 'MLS #', '', 1, 0, 0, NULL, '', 80, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(87, 4, 'text', 'lot_size1', 'Lot', '', 2, 0, 0, '', '', 100, 0, 2, 0, 0, 0, 1, 1, 0, 0, 1),
(88, 4, 'text', 'built_in', 'Built In', '', 3, 0, 0, NULL, '', 90, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1),
(89, 4, 'checkbox', 'single_family', 'Single Family', '', 4, 0, 0, '', '', 25, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(90, 6, 'singleselect', 'laundry', 'Laundry', '', 1, 0, 0, '', '', 120, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(91, 6, 'text', 'floor_size', 'Floor size', '', 2, 0, 0, NULL, '', 60, 0, 2, 0, 0, 0, 1, 1, 0, 0, 1),
(92, 6, 'text', 'parcel', 'Parcel #', '', 3, 0, 0, NULL, '', 100, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(96, 4, 'singleselect', 'cooling_system1', 'Cooling', '', 1, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(97, 4, 'singleselect', 'heating_system1', 'Heating', '', 2, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(100, 5, 'text', 'struture_stype', 'Structure Type', '', 5, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(101, 5, 'text', 'roof_type', 'Roof Type', '', 6, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(102, 5, 'text', 'unit_count', 'Unit Count', '', 7, 0, 0, '', '', 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1),
(103, 5, 'text', 'room_count', 'Room Count', '', 8, 0, 0, '', '', 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1);

INSERT INTO `#__osrs_extra_field_options` (`id`, `field_id`, `field_option`, `ordering`) VALUES
(1, 87, 'option 1', 1),
(2, 87, 'option 2', 2),
(33, 97, 'Center', 1),
(30, 96, 'Center', 1),
(32, 96, 'Front-end', 2),
(34, 97, 'Other', 2),
(39, 100, 'Yes', 1),
(40, 100, 'No', 2),
(41, 101, 'Yes', 1),
(42, 101, 'No', 2),
(43, 102, 'Yes', 1),
(44, 102, 'No', 2),
(45, 103, 'Yes', 1),
(46, 103, 'No', 2),
(63, 90, 'Other', 2),
(62, 90, 'In Unit', 1),
(53, 89, 'Yes', 1),
(54, 89, 'No', 2),
(61, 96, 'Back-end', 3);

INSERT INTO `#__osrs_extra_field_types` (`id`, `fid`, `type_id`) VALUES
(12, 87, 5),
(11, 87, 4),
(10, 87, 6),
(9, 87, 1),
(8, 87, 3),
(7, 87, 2),
(24, 88, 5),
(23, 88, 4),
(22, 88, 6),
(21, 88, 1),
(20, 88, 3),
(19, 88, 2),
(25, 89, 2),
(26, 89, 3),
(27, 89, 1),
(28, 89, 6),
(29, 89, 4),
(30, 89, 5),
(42, 86, 5),
(41, 86, 4),
(40, 86, 6),
(39, 86, 1),
(38, 86, 3),
(37, 86, 2),
(43, 96, 2),
(44, 96, 3),
(45, 96, 1),
(46, 96, 6),
(47, 96, 4),
(48, 96, 5),
(66, 97, 5),
(65, 97, 4),
(64, 97, 6),
(63, 97, 1),
(62, 97, 3),
(61, 97, 2),
(67, 100, 2),
(68, 100, 3),
(69, 100, 1),
(70, 100, 6),
(71, 100, 4),
(72, 100, 5),
(73, 101, 2),
(74, 101, 3),
(75, 101, 1),
(76, 101, 6),
(77, 101, 4),
(78, 101, 5),
(79, 102, 2),
(80, 102, 3),
(81, 102, 1),
(82, 102, 6),
(83, 102, 4),
(84, 102, 5),
(85, 103, 2),
(86, 103, 3),
(110, 90, 5),
(109, 90, 4),
(108, 90, 6),
(107, 90, 1),
(106, 90, 3),
(105, 90, 2),
(93, 91, 2),
(94, 91, 3),
(95, 91, 1),
(96, 91, 6),
(97, 91, 4),
(98, 91, 5),
(99, 92, 2),
(100, 92, 3),
(101, 92, 1),
(102, 92, 6),
(103, 92, 4),
(104, 92, 5);