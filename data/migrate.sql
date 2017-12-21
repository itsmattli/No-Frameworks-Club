CREATE TABLE IF NOT EXISTS `leaderboards` (
  `userId` int(11) NOT NULL,
  `leaderboardId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`userId`,`leaderboardId`)
);

CREATE TABLE IF NOT EXISTS `transactions` (
  `transactionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `currencyAmount` int(11) NOT NULL,
  `verifier` varchar(255) NOT NULL,
  PRIMARY KEY (`transactionId`)
);

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL,
  `dataKey` varchar(255) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`userId`,`dataKey`)
);
