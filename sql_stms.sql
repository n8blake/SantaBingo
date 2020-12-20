INSERT INTO `games` (`gameID`, `start_time`, `end_time`, `game_types`, `called_numbers`, `active`) VALUES (NULL, CURRENT_TIMESTAMP, NULL, '[\"bingo\"]', '[0]', '0');

UPDATE `games` SET `gameID`=[value-1],`start_time`=[value-2],`end_time`=[value-3],`game_types`=[value-4],`called_numbers`=[value-5],`active`=[value-6] WHERE 1


INSERT INTO `cards`(`userID`, `card`) VALUES ((SELECT `userID` FROM `users` WHERE users.email='n8blake@mac.com'), "[]")