var TITEMS = [ 
 ["mxBB-Portal Help", "chapters/helpimages/contents.htm", "1",
  ["Introduction", "chapters/introduction/contents.htm", "1",
   ["About mxBB-Portal", "chapters/introduction/overview.htm", "11"],
   ["Why mxBB-Portal", "chapters/introduction/why_mxbb.htm", "11"],
   ["Why not mxBB", "chapters/introduction/why_not_mxbb.htm", "11"]
  ],
  ["Installing, Upgrading, Unistalling", null, "1",
   ["Installing mxBB-Portal Help", "chapters/installing/contents.htm", "1",
    ["Requirements for mxBB-Portal", "chapters/installing/requirements.htm", "11"],
    ["Download mxBB-Portal Packages", "chapters/installing/download_packages.htm", "11"],
    ["Uploading mxBB-Portal", "chapters/installing/uploading.htm", "11"],
    ["mxBB-Portal Installation Wizard", "chapters/installing/the_installation_wizard.htm", "11"],
    ["Confirmations", "chapters/installing/confirmation.htm", "11"]
   ],
   ["Upgrading mxBB-Portal Help", "chapters/upgrading/contents.htm", "1",
    ["Upgrading Introduction", "chapters/upgrading/introduction.htm", "11"],
    ["Methods of Upgrading", null, "1",
     ["Full Package Upgrade", "chapters/upgrading/full.htm", "11"],
     ["Changed files", "chapters/upgrading/changed_files.htm", "11"],
     ["Code Changes", "chapters/upgrading/code_changes.htm", "11"]
    ]
   ],
   ["Uninstalling", "chapters/uninstalling/contents.htm", "1",
    ["Backup Data", "chapters/uninstalling/backup_data.htm", "11"],
    ["Uninstalling", "chapters/uninstalling/uninstalling.htm", "11"]
   ],
   ["Confirmation", "chapters/upgrading/confirmation.htm", "11"]
  ],
  ["mxBB-Portal Administration", "chapters/administration/introduction.htm", "1",
   ["Administration Introduction", "chapters/administration/introduction.htm", "11"]
  ]
 ]
];


var FITEMS = arr_flatten(TITEMS);

function arr_flatten (x) {
   var y = []; if (x == null) return y;
   for (var i=0; i<x.length; i++) {
      if (typeof(x[i]) == "object") {
         var flat = arr_flatten(x[i]);
         for (var j=0; j<flat.length; j++)
             y[y.length]=flat[j];
      } else {
         if ((i%3==0))
          y[y.length]=x[i+1];
      }
   }
   return y;
}

