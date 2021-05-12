{ pkgs ? (import <nixpkgs> {}) }:

let
  php' = pkgs.php80;

in pkgs.mkShell {
  buildInputs = [
    # Install make for easy shortands
    pkgs.gnumake

    # Install PHP and composer
    php'
    php'.packages.composer

    # Install style check tools (pick newer versions than on nixos-unstable
    # for better PHP8.0 compatibility, this is fixed on master).
    (php'.packages.phpcbf.overrideAttrs(oa: {
      version = "3.6.0";
      src = pkgs.fetchurl {
        url = "https://github.com/squizlabs/PHP_CodeSniffer/releases/download/3.6.0/phpcbf.phar";
        sha256 = "04wb1imm4934mpy2hxcmqh4cn7md1vwmfii39p6mby809325b5z1";
      };
    }))
    (php'.packages.phpcs.overrideAttrs(oa: {
      version = "3.6.0";
      src = pkgs.fetchurl {
        url = "https://github.com/squizlabs/PHP_CodeSniffer/releases/download/3.6.0/phpcs.phar";
        sha256 = "0sdi78hrwd3r5p1b38qmp89m41kfszh2qn4n5zhq2dmhsjdhjziz";
      };
    }))

    # Install nodejs for PHP LSP to work
    pkgs.nodejs
  ];
}
