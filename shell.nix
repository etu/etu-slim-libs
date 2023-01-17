{ pkgs ? (import <nixpkgs> {}) }:

let
  php' = pkgs.php82;

in pkgs.mkShell {
  buildInputs = [
    # Install make for easy shortands
    pkgs.gnumake

    # Install PHP and composer
    php'
    php'.packages.composer

    # Install phpcbf
    php'.packages.phpcbf

    # Install phpcs
    php'.packages.phpcs

    # Install phpstan
    php'.packages.phpstan

    # Install yaml lint
    pkgs.yamllint
  ];
}
