--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(10) UNSIGNED NOT NULL COMMENT 'Database Generated',
  `profile_first` varchar(255) NOT NULL,
  `profile_last` varchar(255) NOT NULL,
  `profile_email` varchar(255) NOT NULL,
  `profile_active` int(1) UNSIGNED NOT NULL DEFAULT '1',
  `profile_type` varchar(255) DEFAULT NULL,
  `profile_flag` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `profile_created` datetime NOT NULL,
  `profile_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `profile_active` (`profile_active`),
  ADD KEY `profile_type` (`profile_type`),
  ADD KEY `profile_flag` (`profile_flag`),
  ADD KEY `profile_created` (`profile_created`),
  ADD KEY `profile_updated` (`profile_updated`);

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
MODIFY `profile_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Database Generated';
