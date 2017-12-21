INSERT INTO `leaderboards` (`userId`, `leaderboardId`, `score`) VALUES
	(1, 2, 99),
	(1, 3, 45),
	(2, 3, 1),
	(3, 3, 2),
	(4, 3, 3),
	(5, 3, 4),
	(6, 3, 5),
	(7, 3, 6);

INSERT INTO `transactions` (`transactionId`, `userId`, `currencyAmount`, `verifier`) VALUES
	(1, 2, 3, 'fd6b91387c2853ac8467bb4d90eac30897777fc6'),
	(2, 2, 5, '5053c523167aa248c1a694f548b65f0c152ccff4'),
	(3, 2, 15, '903dd02d549cc87cf182321b835882b6dff8bf1c');

INSERT INTO `users` (`userId`, `dataKey`, `data`) VALUES
	(1, 'Piece1', '{"SubData":1234,"SubData2":"abcd"}'),
	(1, 'Piece2', '{"SubData":{"SubSubData":9999}}');
