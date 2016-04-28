package flash.zombie.nlp.realize;

/**
 *
 */
public class ZombieToken {

    enum ZombieTokenType {ROOT,WORD,NON_WORD,ST,STZ,LB};

    public ZombieToken(ZombieTokenType type) {
        this.type = type;
    }

    String text;
    Double lineBreakScore;
    ZombieTokenType type;
    ZombieToken prior;
    ZombieToken next;

    public ZombieToken remove() {
        if (prior != null)
            prior.next = next;
        if (next != null)
            next.prior = prior;
        next = null;
        prior = null;
        return this;
    }


    public ZombieToken replace(ZombieToken token) {

        token.next = next;
        token.prior = prior;
        if (prior != null)
            prior.next = token;
        if (next != null)
            next.prior = token;
        return this;
    }


    public ZombieToken insertSelfAfter(ZombieToken afterThis) {

        // Setup this token's references first
        next = afterThis.next;
        prior = afterThis;

        // Now setup references to this token
        prior.next = this;
        next.prior = this;
        return this;
    }


    public ZombieToken insertSelfBefore(ZombieToken beforeThis) {

        // Setup this token's references first
        prior = beforeThis.prior;
        next = beforeThis;

        // Now setup references to this token
        prior.next = this;
        next.prior = this;
        return this;
    }
}
