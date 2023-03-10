# devenv.nix
{ pkgs, inputs, ... }: {
  packages = [ pkgs.nodejs-16_x pkgs.yarn pkgs.mariadb_104];
  languages.javascript.enable = true;
  # Uses by default the latest LTS
  languages.javascript.package = pkgs.nodejs-16_x;

  languages.php.package = inputs.phps.packages.${builtins.currentSystem}.php71;

  languages.php.enable = true;

  services.mysql.package = pkgs.mariadb_104;
  services.mysql.enable = true;

  services.mysql.initialDatabases = [{ name = "app"; }];
  services.mysql.ensureUsers = [
    {
        name = "app";
        password = "app";
        ensurePermissions = { "app.*" = "ALL PRIVILEGES"; };
    }
  ];


}