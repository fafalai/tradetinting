<?php
function RemedyUuid($len = 20, $upper = false)
{
  $hex = md5("ianp" . uniqid("", true));

  $pack = pack('H*', $hex);

  // Max 22 chars

  $uid = base64_encode($pack);

  // Mixed case...

  $uid = preg_replace("#[^A-Za-z0-9]#", "", $uid);

  // Uppercase only...
  if ($upper)
    $uid = preg_replace("#[^A-Z0-9]#", "", strtoupper($uid));

  // Sanity checks

  if ($len < 4)
    $len = 4;
  if ($len > 128)
    $len = 128;

  // Append until desired length...

  while (strlen($uid) < $len)
    $uid = $uid . RemedyUuid(22);

  return substr($uid, 0, $len);
}
?>
