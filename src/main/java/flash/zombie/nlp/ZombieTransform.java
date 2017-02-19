package flash.zombie.nlp;

import flash.zombie.nlp.model.Incident;
import flash.zombie.nlp.realize.Realizer;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;


@Controller
@EnableAutoConfiguration
class ZombieTransform {



    @ModelAttribute("incident")
    public Incident getTransformation(){
        return new Incident();
    }

//    @RequestMapping("/master")
//    @ResponseBody
//    String master() {
//        return
//                zombieMasterText;
//    }

//
//    @RequestMapping("/master/select")
//    @ResponseBody
//    String master(String tregex) {
//        return
//                zombieMasterText;
//    }

    @ModelAttribute
    public Incident incident(@RequestParam(required=false) String text) {
        Incident incident = new Incident();
        incident.victimText = text;
        return incident;
    }

    @ModelAttribute
    public Incident incident(
            @RequestParam(required=false) String victimText,
            @RequestParam(required=false) String zombieText) {
        Incident incident = new Incident();
        incident.victimText = victimText;
        incident.zombieText = zombieText;
        return incident;
    }


    @RequestMapping(value="/rerealize", produces = "application/json")
    @ResponseBody
    public Incident rerealize(@RequestBody Incident incident) {

        System.out.println("\n****************************************************************************");
        System.out.println(incident.getZombieText());

        if (incident == null || incident.zombieText == null || incident.zombieText.length() == 0) {
            Incident inc = new Incident();
            inc.setZombieText("no zombie text provided");
            return inc;
        }

        Decomposition decomposition = new Decomposition(incident.zombieText, false);
        incident.setZombie(decomposition.getSentences());
        new Realizer().realize(incident);
        System.out.println(incident.getZombieText());
        return incident;
    }


    @RequestMapping(value="/victim", produces = "application/json")
    @ResponseBody
    public Incident victim(@RequestBody Incident incident) {

        if (incident == null || incident.victimText == null || incident.victimText.length() == 0){
            Incident inc = new Incident();
            inc.setZombieText("no victim text provided");
            return inc;
        }

        progenitor.attack(incident);



        System.out.println("\n****************************************************************************");
        System.out.println("****************************************************************************\n");

//        for (String mutation : incident.zombieMutations) {
//            System.out.println(mutation);
//        }
//
//        for (Tree victimTree : incident.getVictimParseTrees()) {
//            System.out.println(victimTree.toString());
//        }

        System.out.println(incident.getZombieText());

        // Return name of view to render
//        IncidentReport report = new IncidentReport();
//        report.zombie = incident.getZombieText();
//        report.setZombieMutations(incident.zombieMutations);
        return incident;
    }

//    @RequestMapping(value="/victim_test"/*,  method= RequestMethod.POST*/)
////    @ResponseBody
//    public String victimTest(
//            Incident incident, Model model) {
//
//        if (incident == null || incident.victimText == null) return "victim_test";
//
//        progenitor.attack(incident);
//        model.addAttribute("incident", incident);
//
//        // Return name of view to render
//        return "victim_test";
//    }




    private Progenitor progenitor;

    private void init() {
        progenitor = new Progenitor();
    }

    public ZombieTransform() {
        init();
    }



}